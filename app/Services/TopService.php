<?php
namespace App\Services;

use App\Models\Recipe;

class TopService
{
    // なんでここでコンストラクタメソッドをする必要があるのか？？
    // クラス内でモデルを呼び出すため？
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * トップ画面のレシピ取得
     * 
     * @return array
     */
    public function TopRecipeIndex():array
    {
        $recipes = $this->recipe->getOpenRecipe(3);
        return [
            'recipes' => $recipes
        ];
    }
}

?>