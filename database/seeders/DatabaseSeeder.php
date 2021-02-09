<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RecipeTableSeeder::class);
        $this->call(IngredientTableSeeder::class);
        $this->call(CookingTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
