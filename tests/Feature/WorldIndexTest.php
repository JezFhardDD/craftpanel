<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class WorldIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_world_index_is_accessible_to_guests(): void
    {
        $response = $this->get(route('worlds.index'));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Worlds/Index')
                ->where('joinedWorldIds', [])
        );
    }
}
