<?php

namespace Database\Factories;

use App\Models\Cooking;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class CookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cooking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recipe_id' => Recipe::factory(),
            'content' => 'test-content'
        ];
    }
}
