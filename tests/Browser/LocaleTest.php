<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LocaleTest extends DuskTestCase
{
    public function testUserCanSwitchLocale()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                    ->visit('/locale/nl')
                    ->assertSee('Taal gewijzigd naar Nederlands');

            $browser->visit('/locale/en')
                    ->assertSee('Language switched to English');
        });
    }
}