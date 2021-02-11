<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Favorite;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_タイトルがない場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => '',
                'introduction' => 'test-introduction',
                'amount' => 'test',
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['title']);
    }

    public function test_タイトルが30文字以上の場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => Str::random(31),
                'introduction' => 'test-introduction',
                'amount' => 'test',
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['title']);
    }

    public function test_紹介文がない場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => '',
                'amount' => 'test',
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['introduction']);
    }

    public function test_紹介文が200文字以上の場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => Str::random(201),
                'amount' => 'test',
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['introduction']);
    }

    public function test_分量がない場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => 'test-introduction',
                'amount' => '',
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['amount']);
    }

    public function test_分量が10文字以上場合、レシピの更新ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('recipe.update', [
                'id' => $recipe->id,
                'user_id' => $user->id,
                'title' => 'test-recipe',
                'introduction' => 'test-introduction',
                'amount' => Str::random(11),
                'recipe_img' => '',
                ]));
        $response->assertSessionHasErrors(['amount']);
    }

    #いいね機能のためのメソッドテスト
    public function test_既にいいねをしている()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
        ]);
        $this->actingAs($user)
        ->withSession(['foo' => 'bar']);
        $this->assertTrue($recipe->favorited_by());
    }

    public function test_まだいいねをしていない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $this->actingAs($user)
        ->withSession(['foo' => 'bar']);
        $this->assertFalse($recipe->favorited_by());
    }
}
