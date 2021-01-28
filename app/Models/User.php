<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'profile_img',
        'introduction',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = array('id');
    public static $rules = array(
        'name' => 'required|max:10',
        'introduction' => 'required|max:200',
    );

    public function recipes(){
        return $this->hasMany('App\Models\Recipe');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function favorites(){
        return $this->hasMany('App\Models\Favorite');
    }

     # フォローしている
     public function followings(){
         return $this->belongsToMany('App\Models\User', 'relationships', 'follow_id', 'follower_id');
     }
 
     # フォローされている
     public function followers(){
         return $this->belongsToMany('App\Models\User', 'relationships', 'follower_id', 'follow_id');
     }

    #フォローしたユーザーかどうか判断
     public function followed_by(){
         #ログイン中ユーザーのフォローに$thisユーザーがいなければ(null)フォローを外す(true)を表示
         #followingを 'App\Models\User' として扱っているので、 'id' でユーザーのidが検索される
         if((Auth::user()->followings->where('id', $this->id)->first()) != null){
            return true;
         }else{
            return false;
         } 
     }
}
