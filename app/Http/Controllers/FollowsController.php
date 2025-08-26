<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowsController extends Controller
{

 public function store($id)
{
    Follow::create([
        'following_id' => Auth::id(),
        'followed_id' => $id,
    ]);
    return redirect()->back();
}

   public function destroy($id)
{
    Follow::where('following_id', Auth::id())
          ->where('followed_id', $id)
          ->delete();

    return redirect()->back();
}

public function following(Request $request)
{
    // 既にフォローしているか確認
    $check = Follow::where('following_id', Auth::id())
                    ->where('followed_id', $request->user_id);

    // まだフォローしていなければ、追加
    if ($check->count() == 0) {
    Follow::create([
        'following_id' => Auth::id(),
        'followed_id' => $request->user_id,
    ]);
} else {
    $check->delete(); // 既にフォローしていたら解除

}
}

 public function showFollowings()
{
    $user = auth()->user();

    // フォロー中ユーザーのID配列
     $followingIds = $user->followings()->pluck('users.id');

    // フォロー中ユーザーの情報
    $followings = $user->followings;

    // フォロー中ユーザーの投稿一覧
    $posts = Post::with('user')
        ->whereIn('user_id', $followingIds)
        ->latest()
        ->get();

    return view('follows.followList', compact('followings', 'posts', 'followingIds'));
}


public function showFollowed()
{
    $user = auth()->user();

    // フォロワーID
    $followerIds = $user->followers()->pluck('users.id');

    // フォロワー一覧
    $followers = $user->followers;

    // フォロワーの投稿（表示するなら）
    $posts = Post::with('user')
        ->whereIn('user_id', $followerIds)
        ->latest()
        ->get();

    return view('follows.followerList', compact('followers', 'posts'));
}

}
