<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AuthTest extends DuskTestCase
{
    public function testUserCanLogin()
{
    $this->browse(function (Browser $browser) {
        
        $user = User::factory()->create(['password' => bcrypt('password')]);
        $browser->visit('http://localhost:8000/logout');
        $browser->visit('http://localhost:8000/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/')
                ->assertPathIs('/');
    });
}

    public function testUserCanRegister()
    {
        $this->browse(function (Browser $browser) {
            // Simulate logout by submitting the hidden logout form
            $browser->visit('http://localhost:8000')
                    ->script("document.getElementById('logout-form').submit();");

            $browser->visit('http://localhost:8000/register')
                    ->waitFor('input[name="name"]') // Wait for the "name" input field
                    ->type('name', 'Test User')
                    ->type('email', 'testuser@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->select('role', 1) // Select a role with ID 1
                    ->press('Register')
                    ->screenshot('register-page')
                    ->waitForLocation('/')  // Wait for redirect to homepage
                    ->assertPathIs('/');    // Assert we are on the homepage
        });
    }

}