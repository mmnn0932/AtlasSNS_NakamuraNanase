<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class UsersController extends Controller
{
    // ユーザ検索ページ表示
public function create() {
    $currentUserId = Auth::id();
    $followings = auth()->user()->followings()->pluck('followed_id')->toArray();

    $users = User::where('id', '!=', $currentUserId)->get();

    return view('users.search', compact('users', 'followings'));
}
// 検索処理
public function search(Request $request)
{
    $currentUserId = Auth::id();
    $followings = auth()->user()->followings()->pluck('followed_id')->toArray();

    $searchKeyword = $request->input('keyword');

    if ($searchKeyword) {
        $users = User::where('id', '!=', $currentUserId)
                     ->where('username', 'like', '%' . $searchKeyword . '%')
                     ->get();
    } else {
        $users = User::where('id', '!=', $currentUserId)->get();
    }

    return view('users.search', compact('users', 'followings', 'searchKeyword'));
}

}
