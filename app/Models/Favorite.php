<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function recipe(){
        return $this->belongsTo('App\Models\Recipe');
    }
}
