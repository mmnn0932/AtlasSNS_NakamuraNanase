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
    $validated = $request->validate(
        [
            'post' => ['required', 'string', 'min:1', 'max:150'],
        ],
        [
            'post.required' => '投稿内容を入力してください。',
            'post.min'      => '1文字以上で入力してください。',
            'post.max'      => '150文字以内で入力してください。',
        ]
    );

    Post::create([
        'post'    => $validated['post'],
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('index');
}

    public function index(Request $request)
{
    $user = $request->user();

    $followingIds = $user->followings()->pluck('users.id')->push($user->id);

    $posts = Post::with('user')
        ->whereIn('user_id', $followingIds)
        ->latest('posts.created_at')
        ->get();

    return view('posts.index', ['posts' => $posts]);
}



public function update(Request $request, $id)
{
    $validated = $request->validate(
        [
            'post' => ['required', 'string', 'min:1', 'max:150'],
        ],
        [
            'post.required' => '投稿内容を入力してください。',
            'post.min'      => '1文字以上で入力してください。',
            'post.max'      => '150文字以内で入力してください。',
        ]
    );

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
