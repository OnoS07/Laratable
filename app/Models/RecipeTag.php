<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeTag extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public static $rules = array(
        'tag_name' => 'required|max:5'
    );

    public function recipe(){
        return $this->belongsTo('App\Models\Recipe');
    }
}
