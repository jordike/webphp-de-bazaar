<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Theme;

class ThemeTest extends DuskTestCase
{
    public function testUserCanViewThemes()
    {
        $this->browse(function (Browser $browser) {
            $company = Company::factory()->create();
            Theme::factory()->create(['name' => 'Sample Theme', 'company_id' => $company->id]);

            $browser->loginAs(User::factory()->create(['company_id' => $company->id]))
                    ->visit("/company/{$company->id}/theme")
                    ->assertSee('Sample Theme');
        });
    }

    public function testUserCanUseTheme()
    {
        $this->browse(function (Browser $browser) {
            $company = Company::factory()->create();
            $theme = Theme::factory()->create(['company_id' => $company->id]);

            $browser->loginAs(User::factory()->create(['company_id' => $company->id]))
                    ->visit("/company/{$company->id}/theme")
                    ->press("@use-theme-{$theme->id}")
                    ->assertSee('Theme applied successfully!');
        });
    }

    public function testUserCanUnuseTheme()
    {
        $this->browse(function (Browser $browser) {
            $company = Company::factory()->create();
            $theme = Theme::factory()->create(['company_id' => $company->id]);

            $browser->loginAs(User::factory()->create(['company_id' => $company->id]))
                    ->visit("/company/{$company->id}/theme")
                    ->press("@unuse-theme-{$theme->id}")
                    ->assertSee('Theme unapplied successfully!');
        });
    }
}