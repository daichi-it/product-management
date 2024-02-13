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
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->paginate(5);
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        $item = new Item();
        return view('items.create', compact('item'));
    }


    public function confirm(Request $request, Item $item = null)
    {
        // バリデーション
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'arrival_source' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'price' => 'required|integer',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/'
        ]);
        
        // 新規登録か更新かを判断
        $isUpdate = !is_null($item);
        
        //セッションに情報を保存
        $request->session()->put('validatedData', $validatedData);
        $request->session()->put('isUpdate', $isUpdate);

        return view('items.confirm', compact('item'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->session()->get('validatedData', []);
        if (!$validatedData) {
            return redirect(route('items.create'))
                ->withErrors(['error' => 'セッションが失われました。もう一度入力してください。']);
        }

        DB::transaction(function () use ($validatedData) {
            $item = new Item([
                'product_name' => $validatedData['product_name'],
                'arrival_source' => $validatedData['arrival_source'],
                'manufacturer' => $validatedData['manufacturer'],
                'price' => $validatedData['price'],
            ]);   
            $item->save();
    
            $log = new Log([
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'information' => "{$validatedData['email']}がitem_id:{$item->id}の登録処理を実施",
            ]);
            $log->save();
        });

        // データの保存後、セッションからバリデーション済みデータを削除
        $request->session()->forget('validatedData');
        return redirect(route('items.index'));
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
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->session()->get('validatedData', []);
        if (!$validatedData) {
            return redirect(route('items.edit', $item->id))
                ->withErrors(['error' => 'セッションが失われました。もう一度入力してください。']);
        }

        DB::transaction(function () use ($validatedData, $item) {
            $item->product_name = $validatedData['product_name'];
            $item->arrival_source = $validatedData['arrival_source'];
            $item->manufacturer = $validatedData['manufacturer'];
            $item->price = $validatedData['price'];
            $item->save();
    
            $log = new Log([
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'information' => "{$validatedData['email']}がitem_id:{$item->id}の更新処理を実施",
            ]);
            $log->save();
        });
        
        // 完了画面での表示制御用
        $request->session()->put('isUpdate', true);

        // データの保存後、セッションからバリデーション済みデータを削除
        $request->session()->forget('validatedData');
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
}
