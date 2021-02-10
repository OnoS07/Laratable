<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Relationship;

class RelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_フォローの一覧画面が表示できる()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('relationship.following',['id'=>$user]));
        $response->assertStatus(200)
            ->assertViewIs('relationship.following');
    }

    public function test_フォロワーの一覧画面が表示できる()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('relationship.follower',['id'=>$user]));
        $response->assertStatus(200)
            ->assertViewIs('relationship.follower');
    }

    public function test_フォローができる()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $followed = User::factory()->create([
            'name' => 'follow',
            'email' => 'follow@test',
            'email_verified_at' => now(),
            'profile_img' => '',
            'introduction' => '',
            'password' => 'followtest',
            'remember_token' => Str::random(10),
        ]);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('follow',['user_id'=>$followed->id]));
        $this->assertDatabaseHas('relationships', [
            'follow_id' => $user->id,
            'follower_id' => $followed->id,
        ]);
    }

    public function test_フォローを外すことができる()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $followed = User::factory()->create([
            'name' => 'follow',
            'email' => 'follow@test',
            'email_verified_at' => now(),
            'profile_img' => '',
            'introduction' => '',
            'password' => 'followtest',
            'remember_token' => Str::random(10),
        ]);
        $follow = Relationship::create([
            'follow_id' => $user->id,
            'follower_id' => $followed->id,
        ]);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('unfollow',['user_id'=>$followed->id]));
        $this->assertDeleted($follow);
    }
}