<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Contract;

class ContractTest extends DuskTestCase
{
    public function testUserCanViewContracts()
    {
        $this->browse(function (Browser $browser) {
            $company = Company::factory()->create();
            Contract::factory()->create(['title' => 'Sample Contract', 'company_id' => $company->id]);

            $browser->loginAs(User::factory()->create(['company_id' => $company->id]))
                    ->visit("/companies/{$company->id}/contracts")
                    ->assertSee('Sample Contract');
        });
    }

    public function testUserCanDownloadContract()
    {
        $this->browse(function (Browser $browser) {
            $company = Company::factory()->create();
            $contract = Contract::factory()->create(['company_id' => $company->id]);

            $browser->loginAs(User::factory()->create(['company_id' => $company->id]))
                    ->visit("/companies/{$company->id}/contracts")
                    ->press("@download-contract-{$contract->id}")
                    ->assertSee('Contract downloaded successfully!');
        });
    }
}