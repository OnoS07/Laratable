<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_トップ画面が表示される()
    {
        $response = $this->get(route('top.main'));
        $response->assertStatus(200);
    }

    public function test_アバウト画面が表示される()
    {
        $response = $this->get(route('top.about'));
        $response->assertStatus(200);
    }
}
