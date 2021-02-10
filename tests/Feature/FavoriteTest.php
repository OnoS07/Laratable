<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('favorite.store'),[
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
        $response->assertStatus(302)
            ->assertRedirect(route('recipe.show', ['id'=>$recipe]));
        $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
    }

    public function test_いいねの取り消しができる()
    {
        $this->withoutExceptionHandling();
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('favorite.destroy', ['id'=>$favorite, 'recipe_id'=>$favorite->recipe_id]));
        $this->assertDeleted($favorite);
    }
}
