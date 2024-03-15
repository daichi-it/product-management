<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::orderBy('created_at', 'desc')->paginate(5);
        return view('shippings.index', compact('shippings'));
    }

    public function confirm(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/',
        ];

        // バリデーション実行（非同期はこの方法が推奨）
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // バリデーションエラー時の処理
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'tel' => 'required|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/',
        ]);

        $shipping = Shipping::create($validatedData);

        return response()->json(['success' => '出荷先が登録されました。', 'id' => $shipping->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return redirect()->back()->with('error', '指定された出荷先が見つかりませんでした。');
        }
        $shipping->delete();

        return redirect()->back()
            ->with('status', "出荷先(ID: {$id}、名前: {$shipping->name})を削除しました。");  
    }


    public function register(Request $request)
    {
        $shipping = new Shipping();
        return view('shippings.register', compact('shipping'));
    }
}
