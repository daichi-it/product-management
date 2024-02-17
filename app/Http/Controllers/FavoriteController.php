<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store($itemId) {
        $user = \Auth::user();
        if (!$user->is_favorite($itemId)) {
            $user->favorite_items()->attach($itemId);
        }
        return back();
    }
    public function destroy($itemId) {
        $user = \Auth::user();
        if ($user->is_favorite($itemId)) {
            $user->favorite_items()->detach($itemId);
        }
        return back();
    }
}
