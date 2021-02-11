<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;

class IngredientTest extends TestCase
{

    use RefreshDatabase;

    public function test_材料編集画面が表示される()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('ingredient.edit', ['id'=>$recipe]));
        $response->assertStatus(200)
            ->assertViewIs('ingredient.edit');
    }

    public function test_材料の作成ができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.store'),[
                'recipe_id' => $recipe->id,
                'content' => 'test',
                'amount' => 'test'
            ]);
        $response->assertStatus(302)
            ->assertRedirect(route('ingredient.edit', ['id'=>$recipe]));
        $this->assertDatabaseHas('ingredients', [
                'content' => 'test',
            ]);
    }

    public function test_値が正しくない場合、材料の作成ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.store'),[
                'recipe_id' => $recipe->id,
                'content' => 'test-content',
                'amount' => ''
            ]);
        $this->assertDatabaseMissing('ingredients', [
            'content' => 'test-content',
        ]);
    }

    public function test_材料の更新ができる()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update',[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => 'update',
                'amount' => 'test'
            ]));
        $this->assertDatabaseHas('ingredients', [
                'content' => 'update',
            ]);
    }

    public function test_値が正しくない場合、材料の更新ができない()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.update'),[
                'id' => $ingredient->id,
                'recipe_id' => $recipe->id,
                'content' => 'update-content',
                'amount' => ''
            ]);
        $this->assertDatabaseMissing('ingredients', [
            'content' => 'update-content',
        ]);
    }

    public function test_材料の削除ができる()
    {
        $ingredient = Ingredient::factory()->create();
        $recipe = Recipe::find($ingredient->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('ingredient.destroy', ['id'=>$ingredient->id, 'recipe_id'=>$ingredient->recipe_id]));
        $response->assertStatus(302)
            ->assertRedirect(route('ingredient.edit', ['id'=>$recipe]));;
        $this->assertDeleted($ingredient);
    }
}
