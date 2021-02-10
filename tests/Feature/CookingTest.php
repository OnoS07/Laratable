<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Cooking;

class CookingTest extends TestCase
{

    use RefreshDatabase;

   public function test_作り方編集画面が表示される()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('cooking.edit', ['id'=>$recipe]));
        $response->assertStatus(200)
            ->assertViewIs('cooking.edit');
    }

    public function test_作り方の作成ができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.store'),[
                'recipe_id' => $recipe->id,
                'content' => 'test-content',
            ]);
        $response->assertStatus(302)
            ->assertRedirect(route('cooking.edit', ['id'=>$recipe]));
        $this->assertDatabaseHas('cookings', [
                'content' => 'test-content',
            ]);
    }

    public function test_値が正しくない場合、作り方の作成ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.store'),[
                'recipe_id' => $recipe->id,
                'content' => '',
            ]);
            $this->assertDatabaseCount('cookings', 0);
    }

    public function test_作り方の更新ができる()
    {
        $cooking = Cooking::factory()->create();
        $recipe = Recipe::find($cooking->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.update',[
                'id' => $cooking->id,
                'recipe_id' => $recipe->id,
                'content' => 'update-content',
            ]));
        $cooking = Cooking::where('content', 'update-content')->first();
        $this->assertDatabaseHas('cookings', [
                'content' => 'update-content',
            ]);
    }

    public function test_値が正しくない場合、作り方の更新ができない()
    {
        $cooking = Cooking::factory()->create();
        $recipe = Recipe::find($cooking->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.update'),[
                'id' => $cooking->id,
                'recipe_id' => $recipe->id,
                'content' => '',
            ]);
        $this->assertDatabaseHas('cookings', [
            'content' => 'test-content',
        ]);
    }

    public function test_作り方の削除ができる()
    {
        $cooking = Cooking::factory()->create();
        $recipe = Recipe::find($cooking->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.destroy', ['id'=>$cooking->id, 'recipe_id'=>$cooking->recipe_id]));
        $response->assertStatus(302)
            ->assertRedirect(route('cooking.edit', ['id'=>$recipe]));
        $this->assertDeleted($cooking);
    }
}
