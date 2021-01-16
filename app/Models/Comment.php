<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    # idは自動で入力(increments)
    protected $guarded = array('id');

    #バリデーションを作成 $rulesに代入
    public static $rules = array(
        'content' => 'required|max:200',
    );

    #リレーションを作成
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function recipe(){
        return $this->belongsTo('App\Models\Recipe');
    }
}
