<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_コメントの作成ができる()
    {
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('comment.store'),[
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
                'content' => 'test_comment',
            ]);
        $response->assertStatus(302)
            ->assertRedirect(route('recipe.show', ['id'=>$recipe]));
        $this->assertDatabaseHas('comments', [
                'content' => 'test_comment',
            ]);
    }

    public function test_値が正しくない場合コメントの作成ができない()
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
        $this->assertDatabaseCount('cookings', 0);
    }

    public function test_コメントの削除ができる()
    {
        $this->withoutExceptionHandling();
        $recipe = Recipe::factory()->create();
        $user = User::find($recipe->user_id);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('comment.destroy', ['id'=>$comment]));
        $this->assertDeleted($comment);
    }
}
