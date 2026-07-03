<?php

namespace App\Policies;

use App\Models\User;
use App\Models\World;

class WorldPolicy
{
    // In AuthServiceProvider.php
    protected $policies = [
        World::class => WorldPolicy::class,
    ];
    /**
     * Determine if the user can view any worlds.
     */
    public function viewAny(User $user): bool
    {
        return true; // All users can view worlds
    }

    /**
     * Determine if the user can view the world.
     */
    public function view(User $user, World $world): bool
    {
        return true; // All users can view individual worlds
    }

    /**
     * Determine if the user can create worlds.
     */
    public function create(User $user): bool
    {
        return $user->role === 'World Owner';
    }

    /**
     * Determine if the user can update the world.
     */
    public function update(User $user, World $world): bool
    {
        return $user->id === $world->owner_id;
    }

    /**
     * Determine if the user can delete the world.
     */
    public function delete(User $user, World $world): bool
    {
        return $user->id === $world->owner_id;
    }

    /**
     * Determine if the user can manage the world (for your manage route).
     */
    public function manage(User $user, World $world): bool
    {
        return $user->id === $world->owner_id;
    }
    public function restore(User $user, World $world): bool
    {
        return $user->id === $world->owner_id;
    }
    public function forceDelete(User $user, World $world): bool
    {
        return $user->id === $world->owner_id;
    }
}
