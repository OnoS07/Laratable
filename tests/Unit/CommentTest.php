<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    public function test_コメント本文がない場合、コメントの作成ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('comment.store'),[
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
                'content' => '',
            ]);
        $response->assertSessionHasErrors(['content']);
    }

    public function test_コメント本文が200文字以上の場合、コメントの作成ができない()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('comment.store'),[
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
                'content' => str::random(201),
            ]);
        $response->assertSessionHasErrors(['content']);
    }
}

