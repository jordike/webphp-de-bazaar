<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Standaard',
                'selectable' => true
            ],
            [
                'name' => 'Particuliere adverteerder',
                'selectable' => true
            ],
            [
                'name' => 'Zakelijke adverteerder',
                'selectable' => true
            ],
            [
                'name' => 'Platform eigenaar',
                'selectable' => false
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [ 'name' => $role['name'] ],
                [ 'selectable' => $role['selectable'] ]
            );
        }
    }
}
