<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooking extends Model
{
    protected $guarded = array('id');
    public static $rules = array(
        'content' => 'required|max:200'
    );

    public function recipe(){
        $this->belongsTo('App\Model\Recipe');
    }
}
