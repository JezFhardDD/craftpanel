<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_is_displayed_for_guests(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('About')
                ->where('userRole', null)
        );
    }

    public function test_about_page_is_displayed_for_world_owner(): void
    {
        $user = User::factory()->create([
            'role' => 'World Owner',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('about'));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('About')
                ->where('userRole', 'World Owner')
        );
    }
}
