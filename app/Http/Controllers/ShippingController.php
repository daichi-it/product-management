<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest;
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

    public function confirm(ShippingRequest $request)
    {
        return response()->json($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingRequest $request)
    {
        $shipping = Shipping::create($request->validated());
        return response()->json(['success' => '出荷先が登録されました。', 'id' => $shipping->id], 201);
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
