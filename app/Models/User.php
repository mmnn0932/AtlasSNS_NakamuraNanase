<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//このユーザーがフォローしているユーザー
    public function followings()
{
    return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
}
    /**
     * このユーザーをフォローしているユーザー
     */
    public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
}

    public function followingCount()
        {
            return $this->followings()->count();
        }
         public function followerCount()
        {
            return $this->followers()->count();
        }


}
