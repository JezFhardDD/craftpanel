<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules; // Missing import
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string|in:Player,World Owner,Admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'], // Fixed typo: $validated (not $validated)
        ]);

        $this->createPlayerProfileIfNeeded($user);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }


    protected function createPlayerProfileIfNeeded(User $user): void
    {
        if ($user->role !== 'Player') {
            return;
        }

        $user->player()->create([
            'level' => 1,
            'xp_points' => 0,
            'friends_count' => 0,
            'items_owned' => 0,
            'kills_pvp' => 0,
            'kills_pve' => 0,
            'achievements_unlocked' => 0,
        ]);
    }
}