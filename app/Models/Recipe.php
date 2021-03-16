<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class Recipe extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

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
     * 公開済みのレシピ取得用SQL
     */
    public $openRecipe_sql = <<< 'SQL'
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

    /**
     * 公開済みのレシピをランダムに取得
     * 
     * @params itn $count
     * 
     * @return stdClass
     */
    public function getOpenRecipe(int $count)
    {
      $sql = $this->openRecipe_sql;
      return DB::table(DB::raw("({$sql})"))
        ->inRandomOrder()->take($count)->get();
    }

    /**
     * 公開済みのレシピ一覧を取得
     * 
     * @params itn $count
     * 
     * @return stdClass
     */
    public function getIndexRecipe(){
      $sql = $this->openRecipe_sql;
      return DB::table(DB::raw("({$sql})"))
        ->get();
    }

    /**
     * 検索されたタグに基づく公開済みのレシピ一覧を取得
     * 
     * @params string $tag
     * 
     * @return stdClass
     */
    public function getTagRecipeIndex(string $tag){
        $recipe_tags = DB::table('recipe_tags')->where('tag_name',$tag);
        $recipe_tag_ids = $recipe_tags->pluck('recipe_id');
        $sql = $this->openRecipe_sql;
        return DB::table(DB::raw("({$sql})"))
          ->whereIn('id',$recipe_tag_ids)->where('recipe_status', 'open')->get();
    }

    /**
     * 検索されたワードに基づく公開済みのレシピ一覧を取得
     * 
     * @params string $tag
     * 
     * @return stdClass
     */
    public function getSearchRecipeIndex(string $word){
      $sql = $this->openRecipe_sql;

      return DB::table(DB::raw("({$sql})"))
      ->where('title', 'LIKE', "%{$word}%")->orWhere('introduction', 'LIKE', "%{$word}%")
      /**
       * #orWherehasはORM専用なのでクエリビルダでは使えず
       * #ネスト先の材料に検索ワードが入っているレシピを取得
          ->orWherehas('ingredients', function($query) use($word){
              $query->where('content', 'LIKE', "%{$word}%");
          })
          #ネスト先のタグに検索ワードが入っているレシピを取得
          ->orWherehas('recipe_tags', function($query) use($word){
              $query->where('tag_name', 'LIKE', "%{$word}%");
          })
       */
      ->get();
  }
}
