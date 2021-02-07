<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー詳細画面が表示される()
    {
        $user = User::factory()->create();
        $response = $this->get(route('user.show',['id'=>$user]));
        $response->assertStatus(200);
    }

    public function test_ユーザー編集画面が表示される()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.edit',['id'=>$user]));
        $response->assertStatus(200);
    }
}
