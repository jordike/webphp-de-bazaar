<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\RentedProduct;

class RentTest extends DuskTestCase
{
    public function testUserCanViewReturnPage()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $rentedProduct = RentedProduct::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit("/rent/{$rentedProduct->id}/return")
                    ->assertSee('Return Product');
        });
    }

    public function testUserCanSubmitReturn()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $rentedProduct = RentedProduct::factory()->create(['user_id' => $user->id]);

            $browser->loginAs($user)
                    ->visit("/rent/{$rentedProduct->id}/return")
                    ->press('Submit Return')
                    ->assertSee('Product returned successfully!');
        });
    }
}