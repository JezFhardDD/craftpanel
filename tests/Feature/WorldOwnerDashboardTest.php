<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class WorldOwnerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_world_owner_dashboard_returns_the_selected_background_image_for_owned_worlds(): void
    {
        $owner = User::factory()->create([
            'role' => 'World Owner',
        ]);

        $world = World::create([
            'name' => 'Pale World',
            'owner_id' => $owner->id,
            'max_players' => 10,
            'status' => 'active',
            'background_image' => 'pale',
        ]);

        $response = $this->actingAs($owner)->get(route('world-owner.dashboard'));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('WorldOwnerDashboard')
                ->where('ownedWorlds.0.id', $world->id)
                ->where('ownedWorlds.0.background_image', 'pale')
        );
    }
}
