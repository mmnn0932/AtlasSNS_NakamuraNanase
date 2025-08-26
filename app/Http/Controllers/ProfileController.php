<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{

    public function pageA()
    {
        $user = auth()->user();
        return view('profiles.profile', [
            'user' => $user,
            'type' => 'A' // ここで 'A' をビューに渡している
        ]);
    }

    public function pageB($id)
{
    $user  = User::findOrFail($id); // 表示対象ユーザー（なければ404）
    $posts = Post::where('user_id', $user->id)->latest('posts.created_at')->get();

    // ログイン中ユーザーがフォローしているユーザーID一覧
    $followings = auth()->user()->followings()->pluck('users.id')->toArray();
    // または ->pluck('id')->toArray()

    return view('profiles.profile', [
        'type'       => 'B',
        'user'       => $user,
        'posts'      => $posts,
        'followings' => $followings,
    ]);
}

   public function update(Request $request)
{
    $user = auth()->user();

    // バリデーション
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'bio' => 'nullable|string',
        'icon_image' => 'nullable|image|max:2048',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // 更新処理
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->bio = $request->input('bio');

    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    if ($request->hasFile('icon_image')) {
    $file = $request->file('icon_image');
    $filename = time() . '_' . $file->getClientOriginalName();
    // publicフォルダに保存
    $file->move(public_path('images'), $filename);
    $user->icon_image = $filename;
}
    $user->save();

    return redirect()->route('pageA')->with('success', 'プロフィールを更新しました');
}



}
