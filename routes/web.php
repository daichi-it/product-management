<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 商品
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');
    Route::post('/items/confirm', [ItemController::class, 'confirm'])->name('items.confirm');
    Route::get('/items/complete', [ItemController::class, 'complete'])->name('items.complete');
    Route::post('/items/{item}/confirm', [ItemController::class, 'confirm'])->name('items.update.confirm');
    Route::get('/items/{item}', [ItemController::class, 'edit'])->name('items.edit');
    Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/favorite_items', [ItemController::class, 'favorite_items'])->name('items.favorite_items');

    // お気に入り
    Route::post('/items/{item}/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/items/{item}/unfavorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
    Route::get('/favorites', [FavoriteController::class, 'favorite_items'])->name('favorites');
    // favorites.indexとかitems.favoritesとかにする必要はない？

    // 問い合わせ
    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
    Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');
    
    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ログ
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // カート
    Route::get('/cart', [CartItemController::class, 'index'])->name('cart_items.index');
    Route::post('/cart/add_cart/{item}', [CartItemController::class, 'add_cart'])->name('cart_items.add_cart');
    
    // カートajax
    Route::patch('/cart/update/{item}', [CartItemController::class, 'update'])->name('cart_items.update');
    Route::delete('/cart/delete/{item}', [CartItemController::class, 'destroy'])->name('cart_items.destroy');
    // 購入
    Route::post('/cart', [CartItemController::class, 'purchase'])->name('purchase');


    

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // マイページ
    Route::get('/mypage', function () {
        return view('mypage');
    })->name('mypage');
});

require __DIR__.'/auth.php';
