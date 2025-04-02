<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
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
                'id' => RoleEnum::STANDARD,
                'name' => 'Standaard',
                'selectable' => true
            ],
            [
                'id' => RoleEnum::PRIVATE_ADVERTISER,
                'name' => 'Particuliere adverteerder',
                'selectable' => true
            ],
            [
                'id' => RoleEnum::BUSINESS_ADVERTISER,
                'name' => 'Zakelijke adverteerder',
                'selectable' => true
            ],
            [
                'id' => RoleEnum::PLATFORM_OWNER,
                'name' => 'Platform eigenaar',
                'selectable' => false
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [ 'id' => $role['id'] ],
                [
                    'name' => $role['name'],
                    'selectable' => $role['selectable']
                ]
            );
        }
    }
}
