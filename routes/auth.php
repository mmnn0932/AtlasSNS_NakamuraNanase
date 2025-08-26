<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //新規ユーザー登録
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register'); // 登録画面表示
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store'); // ユーザー登録処理

    //登録完了
    Route::get('added', [RegisteredUserController::class, 'added']);//登録完了画面表示
});
