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
    $request->validate([
    'username' => ['required', 'min:2', 'max:12'],
    'email' => ['required', 'email', 'min:5', 'max:40', 'unique:users'],
    'password' => ['required', 'alpha_num', 'confirmed', 'min:8', 'max:20'],
]);
    User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // セッションにユーザーネームを保存して、次のページで表示
    return redirect('added')->with('username', $request->username);
}

    public function added(): View
{
    // セッションから username を取得し、ビューに渡す
    $username = session('username');
    return view('auth.added', compact('username'));
}
}
