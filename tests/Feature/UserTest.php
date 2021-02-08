<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー詳細画面が表示される()
    {
        $user = User::factory()->create();
        $response = $this->get(route('user.show',['id'=>$user]));
        $response->assertStatus(200)
            ->assertViewIs('user.show');
    }

    public function test_ユーザー編集画面が表示される()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.edit',['id'=>$user]));
        $response->assertStatus(200)
            ->assertViewIs('user.edit');
    }

    public function test_ユーザー情報の更新リクエストが成功する()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('user.update',['id'=>$user]));
        $response->assertStatus(302);
    }
}
