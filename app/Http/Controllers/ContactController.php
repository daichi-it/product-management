<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // フォーム表示
    public function create()
    {
        // $product = new Product();
        // return view('products.create', compact('product'));
        return view('contact.create');
    }
    
    // 送信処理
    public function store(Request $request)
    {
        // バリデーション
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
    
        // ここでお問い合わせ内容をデータベースに保存したり、メールを送信したりする
    
        return redirect()->route('contact.create')->with('success', 'お問い合わせありがとうございます！');
    }
    
    // 確認画面表示（オプション）
    public function confirm(Request $request)
    {
        $data = $request->all();

        // 確認画面のビューを返す
        return view('contact.confirm', compact('data'));
    }

    // 送信完了画面表示
    public function complete()
    {
        return view('contact.complete');
    }
}
