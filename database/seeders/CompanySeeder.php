<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bazaar = new Company();
        $bazaar->fill([
            'user_id' => 4, // Admin user ID
            'name' => 'Bazaar',
            'email' => 'info@debazaar.nl',
            'phone' => '0612345678',
            'address' => 'Bazaarstraat 1',
            'city' => 'Amsterdam',
        ]);
        $bazaar->save();

        $admin = User::find(4);
        $admin->company_id = $bazaar->id;
        $admin->save();
    }
}
