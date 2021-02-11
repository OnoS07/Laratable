<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Relationship;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザーログインができる()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
            ]);
        $response->assertStatus(302)
            ->assertRedirect(route('top.main'));
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
        ]);
    }

    public function test_名前がない場合、ユーザーの更新ができない()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('user.update',[
                'id' => $user->id,
                'name' => '',
                'email' => 'test@test',
            ]));
        $response->assertSessionHasErrors(['name']);
    }


    public function test_名前が10文字以上の場合、ユーザーの更新ができない()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('user.update',[
                'id' => $user->id,
                'name' => Str::random(11),
                'email' => 'test@test',
            ]));
        $response->assertSessionHasErrors(['name']);
    }

    public function test_メールアドレスがない場合、ユーザーの更新ができない()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('user.update',[
                'id' => $user->id,
                'name' => $user->name,
                'email' => '',
            ]));
        $response->assertSessionHasErrors(['email']);
    }

    public function test_メールアドレスが重複する場合、ユーザーの更新ができない()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create([
            'email' => 'unique@test'
        ]);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('user.update',[
                'id' => $user->id,
                'name' => $user->name,
                'email' => 'unique@test',
            ]));
        $response->assertSessionHasErrors(['email']);
    }

    #フォロー機能のためのメソッドテスト
    public function test_既にフォローをしている()
    {
        $user = User::factory()->create();
        $followed = User::factory()->create([
            'email' => 'follow@test',
        ]);
        $follow = Relationship::create([
            'follow_id' => $user->id,
            'follower_id' => $followed->id,
        ]);
        $this->actingAs($user)
            ->withSession(['foo' => 'bar']);
        $this->assertTrue($followed->followed_by());
    }

    public function test_まだフォローをしていない()
    {
        $user = User::factory()->create();
        $followed = User::factory()->create([
            'email' => 'follow@test',
        ]);
        $this->actingAs($user)
            ->withSession(['foo' => 'bar']);
        $this->assertFalse($followed->followed_by());
    }
}

