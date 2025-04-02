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
                'role_id' => 1, // Standaard
                'password' => 'Password123',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@debazaar.nl',
                'role_id' => 2, // Particuliere adverteerder
                'password' => 'Password456',
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@debazaar.nl',
                'role_id' => 3, // Zakelijke adverteerder
                'password' => 'Password789',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@debazaar.nl',
                'role_id' => 4, // Platform eigenaar
                'password' => 'AdminPassword123',
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
