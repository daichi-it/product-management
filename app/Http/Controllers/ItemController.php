<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // キーワードでの絞り込み
        if ($request->filled('keyword')) {
            $query->where('item_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('arrival_source', 'like', '%' . $request->keyword . '%')
                ->orWhere('manufacturer', 'like', '%' . $request->keyword . '%');
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(5);
        return view('items.index', compact('items'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // セッションデータを取得
        $sessionData = session('data');

        // セッションデータがない場合は、初期化
        if (!$sessionData) {
            $sessionData['item_name'] = '';
            $sessionData['arrival_source'] = '';
            $sessionData['manufacturer'] = '';
            $sessionData['price'] = '';
            $sessionData['email'] = '';
            $sessionData['tel'] = '';
        }
        $data = $sessionData;

        return view('items.create', compact('data'));
    }


    public function confirm(Request $request, Item $item = null)
    {
        // バリデーション
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'arrival_source' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'price' => 'required|integer',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/'
        ]);
        
        // 新規登録か更新かを判断
        $isUpdate = !is_null($item);
        
        //セッションに情報を保存
        $request->session()->put('data', $validatedData);
        $request->session()->put('isUpdate', $isUpdate);

        return view('items.confirm', compact('item'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sessionData = $request->session()->get('data', []);
        if (!$sessionData) {
            return redirect(route('items.create'))
                ->withErrors(['error' => 'セッションが失われました。もう一度入力してください。']);
        }

        DB::transaction(function () use ($sessionData, $request) {
            $item = new Item([
                'item_name' => $sessionData['item_name'],
                'arrival_source' => $sessionData['arrival_source'],
                'manufacturer' => $sessionData['manufacturer'],
                'price' => $sessionData['price'],
            ]);   
            $item->save();
    
            $log = new Log([
                'user_id' => $request->user()->id,
                'email' => $sessionData['email'],
                'tel' => $sessionData['tel'],
                'information' => "{$sessionData['email']}がitem_id:{$item->id}の登録処理を実施",
            ]);
            $log->save();
        });

        // データの保存後、セッションからバリデーション済みデータを削除
        $request->session()->forget('data');
        return redirect(route('items.complete'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        // return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        // セッションデータを取得
        $sessionData = session('data');

        // セッションデータがない場合は、DBデータ
        if (!$sessionData) {
            $sessionData['item_name'] = $item->item_name;
            $sessionData['arrival_source'] = $item->arrival_source;
            $sessionData['manufacturer'] = $item->manufacturer;
            $sessionData['price'] = $item->price;
            $sessionData['email'] = '';
            $sessionData['tel'] = '';
        }
        $data = $sessionData;

        return view('items.edit', compact('data', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $sessionData = session('data');
        if (!$sessionData) {
            return redirect(route('items.edit', $item->id))
                ->withErrors(['error' => 'セッションが失われました。もう一度入力してください。']);
        }

        DB::transaction(function () use ($sessionData, $item, $request) {
            $item->item_name = $sessionData['item_name'];
            $item->arrival_source = $sessionData['arrival_source'];
            $item->manufacturer = $sessionData['manufacturer'];
            $item->price = $sessionData['price'];
            $item->save();
    
            $log = new Log([
                'user_id' => $request->user()->id,
                'email' => $sessionData['email'],
                'tel' => $sessionData['tel'],
                'information' => "{$sessionData['email']}がitem_id:{$item->id}の更新処理を実施",
            ]);
            $log->save();
        });
        
        // 完了画面での表示制御用
        $request->session()->put('isUpdate', true);

        // データの保存後、セッションからバリデーション済みデータを削除
        $request->session()->forget('data');
        return redirect(route('items.complete'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return redirect()->back()->with('error', '指定された商品が見つかりませんでした。');
        }
        $item->delete();

        return redirect()->back()
            ->with('status', "商品(ID:{$id})を削除しました。");        
    }

    public function complete()
    {
        return view('items.complete');
    }

    public function favorite_items()
    {
        $items = \Auth::user()->favorite_items()->orderBy('created_at', 'desc')->paginate(5);
        return view('items.favorite_items', compact('items'));
    }
}
