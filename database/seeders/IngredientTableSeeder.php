<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'recipe_id' => 1,
            'content' => 'test-ingredient',
            'amount' => '1'
        ];
        $recipe = new Ingredient;
        $recipe->fill($params)->save();
    }
}
