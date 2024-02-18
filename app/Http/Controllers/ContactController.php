<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminInquiryNotification;
use App\Mail\UserContactConfirmation;

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
            $rules['shumi'] = 'required'; // 男性の場合、趣味が必須
        } else {
            $rules['tokugi'] = 'required'; // 女性の場合、特技が必須
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
        
        // セッションからvalidatedDataを削除
        $request->session()->forget('validatedData');
        
        return redirect()->route('contact.thanks');
        
    }

    public function thanks()
    {
      return view('contact.thanks');
    }
}
