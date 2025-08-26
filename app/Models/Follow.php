<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['following_id', 'followed_id'];

    public function followings()
{
    return $this->belongsTo(User::class, 'following_id');
} // このユーザーはフォローしている人

    public function follower()
{
    return $this->belongsTo(User::class, 'followed_id');
} // このユーザーはフォロワー（フォローされた人）
}
