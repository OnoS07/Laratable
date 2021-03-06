<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    public static $rules = array(
        'content' => 'required|max:10',
        'amount' => 'required|max:10'
    );

    public function recipe(){
       return $this->belongsTo('App\Models\Recipe');
    }
}
