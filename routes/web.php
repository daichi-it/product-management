<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;

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

    // 問い合わせ
    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
    Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
