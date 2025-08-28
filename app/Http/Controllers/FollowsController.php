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


public function showFollowings()
{
    $user = auth()->user();
    $followingIds = $user->followings()->pluck('users.id');
    $followings = $user->followings;
    $posts = Post::with('user')->whereIn('user_id', $followingIds)->latest()->get();

    return view('follows.followList', compact('followings', 'posts'));
}

public function showFollowed()
{
    $user = auth()->user();
    $followerIds = $user->followers()->pluck('users.id');
    $followers = $user->followers;
    $posts = Post::with('user')->whereIn('user_id', $followerIds)->latest()->get();

    return view('follows.followerList', compact('followers', 'posts'));
}
}
