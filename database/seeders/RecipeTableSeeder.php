<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'user_id' => 1,
            'title' => 'test-recipe',
            'introduction' => 'recipe-intro',
            'recipe_img' => '',
            'amount' => '1'
        ];

        $recipe = new Recipe;
        $recipe->fill($params)->save();
    }
}
