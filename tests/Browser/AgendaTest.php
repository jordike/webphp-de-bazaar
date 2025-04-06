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
            // Create a user with a known password
            $user = User::factory()->create([
                'password' => bcrypt('password')  // Set a password for the user
            ]);

            // Manually log in via the login form
            $browser->visit('http://localhost:8000/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')  // The password we set above
                    ->press('Login')  // Assuming there's a "Login" button
                    ->waitForLocation('/agenda')  // Wait until the URL is /agenda
                    ->assertPathIs('http://localhost:8000/agenda')  // Assert the path is /agenda after login
                    ->screenshot('agenda-list')  // Take a screenshot for debugging
                    ->assertSee('Agenda'); // Ensure the 'Agenda' is visible on the page
        });
    }
}