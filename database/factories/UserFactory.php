<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Alice',
            'email' => 'Alice@alice',
            'email_verified_at' => now(),
            'profile_img' => '',
            'introduction' => 'test-introduction',
            'password' => 'alicealice',
            'remember_token' => Str::random(10),
        ];
    }
}
