<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
   
    public function show(Request $request): Response
    {
        $user = $request->user();
        $player = $user->player;

        return Inertia::render('Profile/Profile', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => $user,
            'playerStats' => [
                'level' => $player->level,
                'xp_points' => $player->xp_points,
                'friends_count' => $player->friends_count,
                'kills_pvp' => $player->kills_pvp,
                'kills_pve' => $player->kills_pve,
                'achievements_unlocked' => $player->achievements_unlocked,
            ]
        ]);
    }

    public function edit(Request $request): Response
    {
        $user = $request->user();
        $player = $user->player;

        return Inertia::render('Profile/Edit', [
            'user' => $user,
            'playerStats' => [
                'level' => $player->level,
                'xp_points' => $player->xp_points,
                'friends_count' => $player->friends_count,
                'kills_pvp' => $player->kills_pvp,
                'kills_pve' => $player->kills_pve,
                'achievements_unlocked' => $player->achievements_unlocked,
            ]
        ]);
    }

    
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    Log::debug('Starting profile update', ['user_id' => $user->id, 'input' => $request->all()]);

    try {
        
        $user->update([
            'name' => $request->name,
            'is_online' => $request->is_online,
        ]);

        Log::debug('User updated', ['user' => $user->toArray()]);

        $player = $user->player()->firstOrFail();
        $player->update([
            'level' => $request->level,
            'xp_points' => $request->xp_points,
            'kills_pvp' => $request->kills_pvp,
            'kills_pve' => $request->kills_pve,
            'achievements_unlocked' => $request->achievements_unlocked,
        ]);

        Log::debug('Player updated', ['player' => $player->toArray()]);

        return Redirect::route('profile.show')
            ->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        Log::error('Profile update failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
    }
}

    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
