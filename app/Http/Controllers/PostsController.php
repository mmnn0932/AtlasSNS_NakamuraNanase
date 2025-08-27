<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follow;


class PostsController extends Controller
{

    public function store(Request $request)
{
    $request->validate([
    'post' => ['required', 'string', 'min:1', 'max:150'],
]);

    // ログインユーザーのIDを取得
    $userId = auth()->user()->id;

    // 投稿を作成
    Post::create([
        'post' => $request->input('post'),
        'user_id' => $userId,
    ]);

    return redirect()->route('index');
}

    public function index(Request $request)
{
    $user = $request->user();

    // フォロー中ユーザーのID（users.id）＋自分のIDをまとめる
    $followingIds = $user->followings()->pluck('users.id')->push($user->id);

    // 投稿を取得（N+1回避のため user を同時ロード）
    $posts = Post::with('user')
        ->whereIn('user_id', $followingIds)   // Collection のまま渡してOK
        ->latest('posts.created_at')          // カラムを明示しておくと安全
        ->get();

    return view('posts.index', ['posts' => $posts]);
}


public function edit($id)
{
    // 渡されてきた記事IDのデータを取得
    $post = Post::where('id', $id)->first();

    return view('posts.index', ['post'=>$post]);
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'post' => 'required|max:150',
    ]);

    $post = Post::findOrFail($id);
    $post->post = $validated['post'];
    $post->save();

    return redirect()->route('index');
}

 public function delete($id)
    {
         Post::where('id', $id)->delete();
         return redirect()->route('index');
    }
}
