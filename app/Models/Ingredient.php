<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $guarded = array('id');
    public static $rules = array(
        'content' => 'required|max:20',
        'amount' => 'required|max:10'
    );

    public function recipe(){
       return $this->belongsTo('App\Models\Recipe');
    }
}
