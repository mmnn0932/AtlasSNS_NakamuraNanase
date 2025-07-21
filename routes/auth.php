<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::middleware('guest')->group(function () {

    //ログイン
    Route::get('login', [AuthenticatedSessionController::class, 'create']);//画面表示
    Route::post('login', [AuthenticatedSessionController::class, 'store']);//ログイン処理をしてtopに飛ぶ

    //新規ユーザー登録
    Route::get('register', [RegisteredUserController::class, 'create']);
    Route::post('register', [RegisteredUserController::class, 'store']);//ユーザー登録処理

    //登録完了
    Route::get('added', [RegisteredUserController::class, 'added']);
    Route::post('added', [RegisteredUserController::class, 'added']);

    //ログアウト
    Route::get('logout', [AuthenticatedSessionController::class, 'logout']);
    Route::post('logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
//ログアウト処理

    //Route::get通信(URI　URLの部品, [〇〇Controller::class, 'method']);

});
