<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Company;

class CompanyTest extends DuskTestCase
{
    public function testUserCanViewCompanies()
    {
        $this->browse(function (Browser $browser) {
            Company::factory()->create(['name' => 'Sample Company']);

            $browser->loginAs(User::factory()->create())
                    ->visit('/company')
                    ->assertSee('Sample Company');
        });
    }

    public function testUserCanCreateCompany()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/company/create')
                    ->type('name', 'New Company')
                    ->press('Create Company')
                    ->assertPathIs('/company')
                    ->assertSee('New Company');
        });
    }

    public function testUserCanEditCompany()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $company = Company::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit("/company/{$company->id}/edit")
                    ->type('name', 'Updated Company')
                    ->press('Update Company')
                    ->assertPathIs('/company')
                    ->assertSee('Updated Company');
        });
    }

    public function testUserCanDeleteCompany()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $company = Company::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit('/company')
                    ->press("@delete-company-{$company->id}")
                    ->assertDontSee($company->name);
        });
    }
}