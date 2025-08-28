<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate(
        [
            'username' => ['required','string','min:2','max:12'],
            'email'    => ['required','string','email','min:5','max:40','unique:users,email'],
            'password' => ['required','string','alpha_num','min:8','max:20','confirmed']
        ],
        [
            'username.required' => 'ユーザー名を入力してください。',
            'username.min'      => 'ユーザー名は2〜12文字で入力してください。',
            'username.max'      => 'ユーザー名は2〜12文字で入力してください。',

            'email.required'    => 'メールアドレスを入力してください。',
            'email.email'       => 'メールアドレスの形式が正しくありません。',
            'email.min'         => 'メールアドレスは5〜40文字で入力してください。',
            'email.max'         => 'メールアドレスは5〜40文字で入力してください。',
            'email.unique'      => 'このメールアドレスは既に使用されています。',

            'password.required' => 'パスワードを入力してください。',
            'password.alpha_num'=> 'パスワードは半角英数字のみで入力してください。',
            'password.min'      => 'パスワードは8〜20文字で入力してください。',
            'password.max'      => 'パスワードは8〜20文字で入力してください。',
            'password.confirmed'=> 'パスワード（確認）が一致しません。'
        ]
    );

    $user = User::create([
        'username' => $validated['username'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password'])
    ]);

    event(new Registered($user));

    return redirect()->route('added')->with('username', $validated['username']);
}
}
