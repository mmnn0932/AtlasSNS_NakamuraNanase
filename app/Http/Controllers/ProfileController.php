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
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profiles.profile', compact('user'));
    }

    public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate(
        [
            'username' => ['required','min:2','max:12'],
            'email'    => ['required','min:5','max:40','unique:users,email,' . $user->id,'email'],
            'password' => ['required','alpha_num','min:8','max:20','confirmed'],

            'bio'        => ['nullable','max:150',],
            'icon_image' => ['nullable','mimes:jpg,jpeg,png,bmp,gif,svg']
        ],
        [
            'username.required'   => 'ユーザー名を入力してください。',
            'username.min'        => 'ユーザー名は2文字以上12文字以内で入力してください。',
            'username.max'        => 'ユーザー名は2文字以上12文字以内で入力してください。',

            'email.required'      => 'メールアドレスを入力してください。',
            'email.min'           => 'メールアドレスは5文字以上40文字以内で入力してください。',
            'email.max'           => 'メールアドレスは5文字以上40文字以内で入力してください。',
            'email.unique'        => 'このメールアドレスは既に使用されています。',
            'email.email'         => 'メールアドレスの形式が正しくありません。',

            'password.required'   => 'パスワードを入力してください。',
            'password.alpha_num'   => 'パスワードを英数字で入力してください。',
            'password.min'        => 'パスワードは8文字以上20文字以内で入力してください。',
            'password.max'        => 'パスワードは8文字以上20文字以内で入力してください。',
            'password.confirmed'  => 'パスワード（確認）が一致しません。',

            'bio.max'          => '自己紹介は150文字以内で入力してください。',

            'icon_image.mimes'      => '・アイコンは jpg、png、bmp、gif、svg の画像のみアップロードできます。'
        ]
    );

    $user->username = $validated['username'];
    $user->email    = $validated['email'];
    $user->bio      = $validated['bio'] ?? null;

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    if ($request->hasFile('icon_image')) {
        $file = $request->file('icon_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $user->icon_image = $filename;
    }

    $user->save();

    return redirect()->route('profile.edit');
}

    public function showUser($id)
{
    $user  = User::findOrFail($id);
    $posts = Post::with('user')
        ->where('user_id', $user->id)
        ->latest('posts.created_at')
        ->get();

    $viewer = auth()->user();

    $isFollowing = $viewer->followings()->whereKey($user->id)->exists();

    return view('users.show_user', compact('user', 'posts', 'isFollowing'));
}
}
