<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_world_owner_profile_includes_saved_world_backgrounds(): void
    {
        $user = User::factory()->create([
            'role' => 'World Owner',
        ]);

        $world = World::create([
            'name' => 'Pale World',
            'owner_id' => $user->id,
            'max_players' => 10,
            'status' => 'active',
            'background_image' => 'pale',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('world-owner.profile'));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Profile/Profile2')
                ->where('worlds.0.id', $world->id)
                ->where('worlds.0.background_image', 'pale')
        );
    }

    public function test_world_owner_viewing_their_world_detail_receives_owner_context(): void
    {
        $user = User::factory()->create([
            'role' => 'World Owner',
        ]);

        $world = World::create([
            'name' => 'Pale World',
            'owner_id' => $user->id,
            'max_players' => 10,
            'status' => 'active',
            'background_image' => 'pale',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('worlds.show', $world));

        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Worlds/World2')
                ->where('world.id', $world->id)
                ->where('isOwner', true)
        );
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
