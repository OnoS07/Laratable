<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Cooking;

class CookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_作り方がない場合、作り方の更新ができない()
    {
        $cooking = Cooking::factory()->create();
        $recipe = Recipe::find($cooking->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.update',[
                'id' => $cooking->id,
                'recipe_id' => $recipe->id,
                'content' => '',
            ]));
        $response->assertSessionHasErrors(['content']);
    }

    public function test_作り方が200文字以上場合、作り方の更新ができない()
    {
        $cooking = Cooking::factory()->create();
        $recipe = Recipe::find($cooking->recipe_id);
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('cooking.update',[
                'id' => $cooking->id,
                'recipe_id' => $recipe->id,
                'content' => str::random(201),
            ]));
        $response->assertSessionHasErrors(['content']);
    }
}
