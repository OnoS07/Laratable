<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'name' => 'test',
            'email' => 'test@test',
            'profile_img' => '',
            'introduction' => '',
            'password' => bcrypt('testtest'),
        ];

        $user = new User;
        $user->fill($params)->save();
    }
}
