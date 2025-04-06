<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvertisementTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateAdvertisement()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/advertisement', [
            'title' => 'Test Advertisement',
            'description' => 'This is a test advertisement.',
            'price' => 100,
            '_token' => csrf_token(), // Include CSRF token if needed
        ]);
        $response->assertRedirect('/advertisement');
        $this->assertDatabaseHas('advertisements', ['title' => 'Test Advertisement']);
    }

    public function testUserCanUpdateAdvertisement()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put("/advertisement/{$advertisement->id}", [
            'title' => 'Updated Advertisement',
            'description' => $advertisement->description,
            'price' => $advertisement->price,
            '_token' => csrf_token(), // Include CSRF token if needed
            '_method' => 'PUT',
        ]);
        $response->assertRedirect('/advertisement');
        $this->assertDatabaseHas('advertisements', ['title' => 'Updated Advertisement']);
    }

    public function testUserCanDeleteAdvertisement()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/advertisement/{$advertisement->id}", [
            '_token' => csrf_token(), // Include CSRF token if needed
            '_method' => 'DELETE',
        ]);
        $response->assertRedirect('/advertisement');
        $this->assertDatabaseMissing('advertisements', ['id' => $advertisement->id]);
    }
}