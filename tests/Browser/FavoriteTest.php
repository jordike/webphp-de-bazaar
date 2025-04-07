<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Advertisement;

class FavoriteTest extends DuskTestCase
{
    public function testUserCanViewFavorites()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create();
            $user->favorites()->attach($advertisement->id);

            $browser->loginAs($user)
                    ->visit('/favorites')
                    ->assertSee($advertisement->title);
        });
    }

    public function testUserCanAddToFavorites()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create();

            $browser->loginAs($user)
                    ->visit("/advertisements/advertisement/{$advertisement->id}")
                    ->press('Add to Favorites')
                    ->assertSee('Added to favorites successfully!');
        });
    }
}