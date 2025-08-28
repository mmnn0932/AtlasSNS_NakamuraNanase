<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FollowsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

//ログアウト
Route::get('logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

// 投稿作成して保存
Route::post('store', [PostsController::class, 'store'])->name('posts.store');

// 投稿一覧//投稿取得して表示
Route::get('index', [PostsController::class, 'index'])->name('index');

// 投稿更新
Route::post('/posts/{id}/update', [PostsController::class, 'update'])->name('posts.update');

// 投稿削除
Route::get('/posts/{id}/delete', [PostsController::class, 'delete'])->name('posts.delete');


Route::post('/follow/{id}', [FollowsController::class, 'store'])->name('follow.store');
Route::delete('/follow/{id}', [FollowsController::class, 'destroy'])->name('follow.destroy');

Route::get('/followlist',   [FollowsController::class, 'showFollowings'])->name('followlist');
Route::get('/followerlist', [FollowsController::class, 'showFollowed'])->name('followerlist');


Route::get('search', [UsersController::class, 'create'])->name('users.search');


Route::get('/search/result', [UsersController::class, 'search'])->name('users.result');


  // 自分のプロフィール編集・更新
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',  [ProfileController::class, 'update'])->name('profile.update');

    // 他ユーザーのプロフィール
    Route::get('/users/{id}', [ProfileController::class, 'showUser'])->name('users.show');

});
