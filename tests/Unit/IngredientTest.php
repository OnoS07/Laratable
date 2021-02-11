<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;

class IngredientTest extends TestCase
{

    use RefreshDatabase;

    public function test_材料名がない場合、材料の更新ができない()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update',[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => '',
                'amount' => 'test'
            ]));
        $response->assertSessionHasErrors(['content']);
    }

    public function test_材料名が10文字以上場合、材料の更新ができない()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update',[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => str::random(11),
                'amount' => 'test'
            ]));
        $response->assertSessionHasErrors(['content']);
    }

    public function test_分量がない場合、材料の更新ができない()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update',[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => 'test-content',
                'amount' => ''
            ]));
        $response->assertSessionHasErrors(['amount']);
    }

    public function test_分量が10文字以上場合、材料の更新ができない()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update',[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => 'test-content',
                'amount' => str::random(11)
            ]));
        $response->assertSessionHasErrors(['amount']);
    }
}
