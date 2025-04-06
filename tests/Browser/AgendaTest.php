<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AgendaTest extends DuskTestCase
{
    public function testUserCanViewAgenda()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                    ->visit('/agenda')
                    ->assertSee('Agenda');
        });
    }
}