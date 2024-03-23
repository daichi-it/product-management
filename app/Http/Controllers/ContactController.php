<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminInquiryNotification;
use App\Mail\UserContactConfirmation;
use App\Models\Contact;
use Carbon\Carbon;

class ContactController extends Controller
{
    // フォーム表示
    public function create()
    {
        return view('contact.create');
    }
       
    // 確認画面表示
    public function confirm(Request $request)
    {
        // バリデーションルール
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'gender' => 'required|in:male,female',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/',
            'message' => 'required',
        ];

        // 趣味 or 特技のバリデーションルールを追加
        if ($request->input('gender') === 'male') {
            $rules['hobby'] = 'required'; // 男性の場合、趣味が必須
        } else {
            $rules['skill'] = 'required'; // 女性の場合、特技が必須
        }
        
        $validatedData = $request->validate($rules);
        
        // セッションに入れる
        $request->session()->put('validatedData', $validatedData);
        
        // 確認画面のビューを返す
        return view('contact.confirm');
    }

    // 送信完了画面表示
    public function send(Request $request)
    {
        // セッションから情報を取得
        $validatedData = $request->session()->get('validatedData', []);

        if (!$validatedData) {
            return redirect(route('items.create'))
                ->withErrors(['error' => 'セッションが失われました。もう一度入力してください。']);
        }
        
        // メール送信の処理
        Mail::to($request->email)->send(new UserContactConfirmation($validatedData));
        Mail::to($request->email)->send(new AdminInquiryNotification($validatedData));
        
        // データベースにレコードを作成
        $data = ['user_id' => auth()->id()] + $validatedData;
        Contact::create($data);

        // セッションからvalidatedDataを削除
        $request->session()->forget('validatedData');
        
        return redirect()->route('contact.thanks');
        
    }

    public function thanks()
    {
      return view('contact.thanks');
    }

    public function showExportCsv()
    {
        $dates = Contact::query()
                         ->selectRaw("DATE_FORMAT(created_at, '%Y年%m月') as formatted_date")
                         ->groupBy('formatted_date')
                         ->orderBy('formatted_date', 'desc')
                         ->get()
                         ->pluck('formatted_date');
        
        return view('contact.exportCsv', compact('dates'));
    }

    public function exportCsv(Request $request)
    {
        
        $formattedDate = $request->input('formatted_date'); // リクエストからformatted_dateを取得
        
        $contacts = Contact::query()
                            ->whereRaw("DATE_FORMAT(created_at, '%Y年%m月') = ?", [$formattedDate])
                            ->orderBy('created_at', 'asc')
                            ->get(['user_id', 'name', 'email', 'gender', 'hobby', 'skill', 'tel', 'message', 'created_at']);
        
        // ファイル名: yyyymm_contacts.csv
        $fileName = Carbon::createFromFormat('Y年m月', $formattedDate)->format('Ym') . '_contacts.csv';
        
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $columns = array('ユーザID', 'ユーザ名', 'メールアドレス', '性別', '趣味', '特技', '電話番号', 'メッセージ', '問い合わせ日時');

        $callback = function() use ($contacts, $columns) {
            $file = fopen('php://output', 'w');
            
            // 文字コードをShift-JISに変換？
            stream_filter_prepend($file, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダ行
            fputcsv($file, $columns);

            // データ
            foreach ($contacts as $contact) {
                fputcsv($file, array($contact->user_id, $contact->name, $contact->email, $contact->gender, $contact->hobby, $contact->skill, $contact->tel, $contact->message, $contact->created_at));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
