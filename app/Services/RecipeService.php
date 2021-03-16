<?php
namespace App\Services;

use App\Models\Recipe;

class RecipeService
{
    // なんでここでコンストラクタメソッドをする必要があるのか？？
    // クラス内でモデルを呼び出すため？
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * レシピ一覧画面のレシピ取得
     * 
     * @return array
     */
    public function RecipeIndex():array
    {
        $recipes = $this->recipe->getIndexRecipe();
        return [
            'recipes' => $recipes
        ];
    }
    
    public function TagRecipeIndex($tag):array
    {
        $recipes = $this->recipe->getTagRecipeIndex($tag);
        return [
            'recipes' => $recipes,
            'tag' => $tag
        ];
    }

    public function SearchRecipeIndex($word):array
    {
        $recipes = $this->recipe->getSearchRecipeIndex($word);
        return [
            'recipes' => $recipes,
            'word' => $word
        ];
    }
    
}

?>