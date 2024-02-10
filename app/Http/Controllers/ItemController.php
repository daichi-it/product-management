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


    public function confirm(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'arrival_source' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'price' => 'required|integer',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/'
        ]);
        
        $request->session()->put('validatedData', $validatedData);

        return view('items.confirm');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
