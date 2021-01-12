<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cooking;

class CookingTableSeeder extends Seeder
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
            'content' => 'test-cooking',
        ];
        $recipe = new Cooking;
        $recipe->fill($params)->save();
    }
}
