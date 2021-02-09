<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_レシピ一覧画面が表示される()
    {
        $response = $this->get(route('recipe.index'));
        $response->assertStatus(200)
            ->assertViewIs('recipe.index');
    }

    public function test_レシピ詳細画面が表示される()
    {
        $recipe = Recipe::factory()->create();
        $response = $this->get(route('recipe.show', ['id'=>$recipe]));
        $response->assertStatus(200)
            ->assertViewIs('recipe.show');
    }

    public function test_レシピ作成画面が表示される()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('recipe.create'));
        $response->assertStatus(200)
            ->assertViewIs('recipe.create');
    }

    public function test_レシピの作成リクエストが成功する()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.store'));
        $response->assertStatus(302);
    }

    public function test_レシピの作成ができる()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.store'),[
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => 'test-introduction',
                'amount' => 'test',
                'recipe_img' => '',
            ]);
        $recipe = Recipe::where('title', 'test-recipe')->first();
        $response->assertStatus(302)
            ->assertRedirect(route('ingredient.edit', ['id'=>$recipe]));
        $this->assertDatabaseHas('recipes', [
                'title' => 'test-recipe',
            ]);
    }

    public function test_値が正しくない場合、レシピの作成ができない()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.store'),[
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => '',
                'amount' => '',
                'recipe_img' => '',
            ]);
        $this->assertDatabaseMissing('recipes', [
            'title' => 'test-recipe',
        ]);
    }

    public function test_レシピ編集画面が表示される()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('recipe.edit', ['id'=>$recipe]));
        $response->assertStatus(200)
            ->assertViewIs('recipe.edit');
    }

    public function test_レシピの編集リクエストが成功する()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', ['id'=>$recipe]));
        $response->assertStatus(302);
    }

    public function test_レシピの更新ができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update'),[
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'update-recipe',
                'introduction' => 'test-introduction',
                'amount' => 'test',
                'recipe_img' => '',
            ]);
        $recipe = Recipe::where('title', 'update-recipe')->first();
        $response->assertStatus(302)
            ->assertRedirect(route('recipe.show', ['id'=>$recipe]));
        $this->assertDatabaseHas('recipes', [
                'title' => 'update-recipe',
            ]);
    }

    public function test_値が正しくない場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update'),[
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'update-recipe',
                'introduction' => '',
                'amount' => '',
                'recipe_img' => '',
            ]);
        $this->assertDatabaseMissing('recipes', [
            'title' => 'update-recipe',
        ]);
    }

    public function test_レシピの削除リクエストが成功する()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.destroy', ['id'=>$recipe]));
        $response->assertStatus(302);
    }

    public function test_レシピの削除ができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.destroy', ['id'=>$recipe]));
        $response->assertStatus(302)
            ->assertRedirect(route('recipe.index'));
        $this->assertDeleted($recipe);
    }
}