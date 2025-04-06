<?php
namespace Tests\Browser;

use App\Enums\RoleEnum;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Advertisement;

class AdvertisementTest extends DuskTestCase
{
    public function testUserCanViewAdvertisements()
    {
        $this->browse(function (Browser $browser) {
            Advertisement::factory()->create(['title' => 'Sample Advertisement']);
            $user = User::factory()->create(['role_id' => RoleEnum::PRIVATE_ADVERTISER]);

            $browser->visit('http://localhost:8000/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Login')
            ->waitForLocation('/');

            $browser
                    ->visit('http://localhost:8000/advertisements/advertisement')
                    ->screenshot('advertisement-list')  // Debugging screenshot
                    ->assertSee('Advertisement');
        });
    }

    public function testUserCanCreateAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            $browser
                    ->visit('http://localhost:8000/advertisements/advertisement/create')
                    ->waitFor('input[name="title"]') // Wait for the title input field to be present
                    ->type('title', 'Test Advertisement')
                    ->type('description', 'This is a test advertisement.')
                    ->type('price', '100')
                    ->attach('photo', public_path('storage/advertisements/9af5223f-852d-471a-a77d-d0b7ed7a5162.jpg')) // Use an existing file
                    ->press('Create Advertisement')
                    ->waitForLocation('/advertisements/advertisement') // Adjust this based on actual route
                    ->assertSee('Test Advertisement');
        });
    }

    public function testUserCanEditAdvertisement()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('http://localhost:8000')
            ->script("document.getElementById('logout-form').submit();");
            $advertisement = Advertisement::factory()->create();

            $user = User::factory()->create(['role_id' => RoleEnum::PRIVATE_ADVERTISER]);
            $advertisement = Advertisement::factory()->create();
            $browser->visit('http://localhost:8000/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Login')
            ->waitForLocation('/');

            $browser->visit("http://localhost:8000/advertisements/advertisement/{$advertisement->id}/edit")
            ->screenshot('tes')
                    ->type('title', 'Updated Advertisement')
                    ->press('Update Advertisement')
                    ->assertPathIs('/advertisements/advertisement')
                    ->assertSee('Updated Advertisement');
        });
    }

    public function testUserCanDeleteAdvertisement()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('http://localhost:8000')
            ->script("document.getElementById('logout-form').submit();");
            
            $user = User::factory()->create(['role_id' => RoleEnum::PRIVATE_ADVERTISER]);
            $advertisement = Advertisement::factory()->create('user_id', $user->id);

            $browser->visit('http://localhost:8000/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Login')
            ->waitForLocation('/');

            $browser
                    ->visit("http://localhost:8000/advertisements/advertisement/{$advertisement->id}/edit")
                    ->screenshot('advertisement-delete') // Debugging screenshot
                    ->press("@delete-advertisement-{$advertisement->id}")
                    ->assertDontSee($advertisement->title);
        });
    }
}