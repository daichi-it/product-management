<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\BuyItem;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \Auth::user();
        $cartItems  = $user->cart_items()->orderBy('created_at', 'desc')->get();
        return view('cart_items.index', compact('cartItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $itemId)
    {
        // 認証済みユーザーのカートから、指定された商品IDに該当するアイテムを検索
        $cartItem = \Auth::user()->cart_items()->where('item_id', $itemId)->first();

        if ($cartItem) {
            // 該当するカートアイテムが存在する場合、数量を更新
            $cartItem->pivot->quantity = $request->input('quantity');
            $cartItem->pivot->save();

            // 更新成功の応答を返す
            return response()->json([
                'message' => 'カートアイテムが更新されました。',
                'quantity' =>$request->input('quantity')
            ]);
        } else {
            // 該当するカートアイテムが存在しない場合、エラー応答を返す
            return response()->json(['message' => 'カートアイテムが見つかりません。'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($itemId) {

        $user = \Auth::user();
        $isInCart = $user->isInCart($itemId);

        if ($isInCart) {
            $user->cart_items()->detach($itemId);
            return response()->json(['message' => 'アイテムがカートから削除されました。']);
        } else {
            // カートにアイテムが存在しない場合、削除を試みずにエラーメッセージを返す
            return response()->json(['message' => 'アイテムはカートに存在しません。'], 404);
        }

    }

    public function add_cart(Request $request, Item $item)
    {
        $user = \Auth::user();
        $cartItem = CartItem::where('user_id', $user->id)->where('item_id', $item->id)->first();

        if ($cartItem) {
            // 商品が既にカートに存在する場合、数量をインクリメント
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // 商品がカートに存在しない場合、新規にレコードを追加
            $user->cart_items()->attach($item->id, ['quantity' => 1]);
        }

        // JSONで非同期リクエストに対するレスポンス
        return response()->json(['success' => 'カートに商品を追加しました。']);
    }
    
    public function purchase(Request $request)
    {

        DB::beginTransaction();
        try {
            $user = \Auth::user();
            $cartItems = $user->cart_items()->get();

            // カートの商品存在チェック
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'カートに商品がありません');
            }
    
            foreach ($cartItems as $cartItem) {
                // 購入履歴に追加
                BuyItem::create([
                    'user_id' => $user->id,
                    'item_id' => $cartItem->pivot->item_id,
                    'quantity' => $cartItem->pivot->quantity,
                    'created_at' => now(),
                ]);

            }

            // カートから削除
            $user->cart_items()->detach();

            DB::commit();

            return redirect()->back()->with('success', '購入完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("購入処理中にエラー発生: " . $e->getMessage());
            return redirect()->back()->with('error', '購入処理に失敗しました');
            
        }
    }

}
