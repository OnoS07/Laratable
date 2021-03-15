<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Recipe extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public static $rules = array(
        'title' => 'required|max:30',
        'introduction' => 'required|max:200',
        'amount' => 'required|max:10'
    );

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

    public function favorites(){
        return $this->hasMany('App\Models\Favorite');
    }

    public function recipe_tags(){
      return $this->hasMany('App\Models\RecipeTag');
    }

    #いいねしたレシピがどうか判断
    public function favorited_by()
    {  
      $favorite_users = array();
      foreach($this->favorites as $favorite) {
        array_push($favorite_users, $favorite->user_id);
      }
  
      if (in_array(Auth::id(), $favorite_users)) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * 公開済みのレシピをランダムに取得
     * 
     * @params itn $count
     * 
     * @return stdClass
     */
    public function getOpenRecipe(int $count)
    {
      $sql = <<< 'SQL'
      SELECT
        R.*,
        U.name as user_name,
        COALESCE((
          SELECT COUNT(*)
          FROM recipes as R
          JOIN comments as Co
            ON R.id = Co.recipe_id
          GROUP BY R.id
        ), 0) as comments,
        COALESCE((
          SELECT COUNT(*)
          FROM recipes as R
          JOIN favorites as F
            ON R.id = F.recipe_id
          GROUP BY R.id
        ), 0) as favorites
      FROM recipes AS R
      LEFT JOIN users as U
        ON R.user_id = U.id
      WHERE R.recipe_status = 'open'
      SQL;

      return DB::table(DB::raw("({$sql})"))
        ->inRandomOrder()->take($count)->get();
    }
}
