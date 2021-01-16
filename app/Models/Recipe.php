<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    # idは自動で入力(increments)
    protected $guarded = array('id');

    #バリデーションを作成 $rulesに代入
    public static $rules = array(
        'title' => 'required|max:30',
        'introduction' => 'required|max:200',
        'amount' => 'required|max:10'
    );

    #リレーションを作成
    public function ingredients(){
        return $this->hasMany('App\Models\Ingredient');
    }

    public function cookings(){
        return $this->hasMany('App\Models\Cooking');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
