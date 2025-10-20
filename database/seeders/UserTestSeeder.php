<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $users = [];

        for ($i = 20; $i <= 30; $i++) {
            $users[] = [
                'user_name' => 'user' . $i,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('123456'),
                'status' => 'active',
                'roles_id' => 2, // role mặc định
                'avatar' => null,
                'login_at' => $now->copy()->subDays(rand(1, 10)),
                'change_password_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($users);
    }
}
