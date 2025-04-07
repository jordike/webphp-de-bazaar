<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Advertisement;
use App\Models\Bid;

class BidTest extends DuskTestCase
{
    public function testUserCanCreateBid()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create();

            $browser->loginAs($user)
                    ->visit("/advertisements/{$advertisement->id}/bid/create")
                    ->type('amount', '100')
                    ->press('Submit Bid')
                    ->assertPathIs("/advertisements/{$advertisement->id}/bid")
                    ->assertSee('Bid submitted successfully!');
        });
    }

    public function testUserCanAcceptBid()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);
            $bid = Bid::factory()->create(['advertisement_id' => $advertisement->id]);

            $browser->loginAs($user)
                    ->visit("/advertisements/{$advertisement->id}/bid")
                    ->press("@accept-bid-{$bid->id}")
                    ->assertSee('Bid accepted successfully!');
        });
    }

    public function testUserCanRejectBid()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);
            $bid = Bid::factory()->create(['advertisement_id' => $advertisement->id]);

            $browser->loginAs($user)
                    ->visit("/advertisements/{$advertisement->id}/bid")
                    ->press("@reject-bid-{$bid->id}")
                    ->assertSee('Bid rejected successfully!');
        });
    }
}