<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@debazaar.nl',
                'role_id' => 1,
                'password' => 'Password123',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@debazaar.nl',
                'role_id' => 2,
                'password' => 'Password456',
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'name' => $user['name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'password' => Hash::make($user['password']),
            ]);
        }
    }
}
