<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'slug' => Str::slug('admin'),
                'role' => '1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'remember_token' => Str::random(100),
            ],
            [
                'username' => 'users',
                'slug' => Str::slug('users'),
                'role' => '0',
                'email' => 'users@gmail.com',
                'password' => Hash::make('123'),
                'remember_token' => Str::random(100),
            ],
        ];

        foreach ($data as $key => $value) {
            User::create($value);
        }
    }
}
