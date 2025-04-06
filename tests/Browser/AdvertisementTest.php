<?php
namespace Tests\Browser;

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

            $browser->loginAs(User::factory()->create())
                    ->visit('/advertisements/advertisement')
                    ->screenshot('advertisement-list')  // Debugging screenshot
                    ->assertSee('Sample Advertisement');
        });
    }

    public function testUserCanCreateAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/advertisements/advertisement/create')
                    ->type('title', 'Test Advertisement')
                    ->type('description', 'This is a test advertisement.')
                    ->type('price', '100')
                    ->attach('photo', __DIR__ . '/test.jpg') // Ensure a valid file path
                    ->press('Create Advertisement')
                    ->assertPathIs('/advertisements/advertisement')
                    ->assertSee('Test Advertisement');
        });
    }

    public function testUserCanEditAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit("/advertisements/advertisement/{$advertisement->id}/edit")
                    ->type('title', 'Updated Advertisement')
                    ->press('Update Advertisement')
                    ->assertPathIs('/advertisements/advertisement')
                    ->assertSee('Updated Advertisement');
        });
    }

    public function testUserCanDeleteAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit('/advertisements/advertisement')
                    ->screenshot('advertisement-delete') // Debugging screenshot
                    ->press("@delete-advertisement-{$advertisement->id}")
                    ->assertDontSee($advertisement->title);
        });
    }
}