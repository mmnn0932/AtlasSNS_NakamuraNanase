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

    // 投稿後に同じページにリダイレクト
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

    public function followList()
{
    $user = Auth::user();

    // フォローしているユーザー一覧
    $followings = $user->followings;

    // フォローしているユーザーの投稿を取得
    $posts = Post::whereIn('user_id', $followings->pluck('id'))
                ->with('user') // 投稿したユーザー情報も取得
                ->latest()
                ->get();

    return view('follows.followList', compact('followings', 'posts'));
}

public function followerList()
{
    // 自分
    $user = Auth::user();

    // 自分をフォローしているユーザー一覧（followList と同じく “コレクション” を取得）
    $followers = $user->followers;

    // フォロワーの投稿だけ取得（users の id を pluck）
    $posts = Post::whereIn('user_id', $followers->pluck('id'))
        ->with('user')                 // 投稿したユーザー情報も取得（N+1回避）
        ->latest('posts.created_at')   // 曖昧さ回避のためカラム明示（任意）
        ->get();

    return view('follows.followerList', compact('posts', 'followers'));
}

public function showFollowings()
{
    $user = Auth::user();

    // フォロー中ユーザーの情報（必要な列だけに絞ると軽い）
    $followings = $user->followings();
    // もし件数や最新投稿も出したければ withCount / latestOfMany を活用

    // フォロー中ユーザーの投稿一覧
    $posts = Post::with('user')
        ->whereIn('user_id', $followings->pluck('id')) // コレクションのまま渡してOK
        ->latest('posts.created_at')
        ->get();

    return view('follows.followList', compact('followings', 'posts'));
}

public function showFollowed()
{
    $user = Auth::user();

    // フォロワー一覧（画面でカード表示などに使う想定。必要な列だけ取ると軽い）
    $followers = $user->followers();

    // フォロワーの投稿一覧（N+1回避のため user を同時ロード）
    $posts = Post::with('user')
        ->whereIn('user_id', $followers->pluck('id'))   // コレクションからID抽出
        ->latest('posts.created_at')                    // カラム名を明示して安全に
        ->get();

    return view('follows.followerList', compact('followers', 'posts', 'followingIds'));
}
}
