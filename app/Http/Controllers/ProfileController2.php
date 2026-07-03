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

class ProfileController2 extends Controller
{

    public function show(Request $request)
    {
        $user = $request->user(); 

        $worlds = $user->ownedWorlds() 
            ->with(['players' => function ($query) {
                $query->withPivot('role_in_world', 'is_kicked', 'is_blocked')
                    ->where('world_members.is_kicked', false)
                    ->where('world_members.is_blocked', false);
            }])
            ->get();

       
        $totalPlayers = $worlds->sum(function ($world) {
            return $world->players->count();
        });

        $activePlayers = $worlds->sum(function ($world) {
            return $world->players->where('is_online', true)->count();
        });

       
        $worldDetails = $worlds->map(function ($world) {
            return [
                'id' => $world->id,
                'name' => $world->name,
                'status' => $world->status,
                'max_players' => $world->max_players,
                'current_players' => $world->players->count(),
                'active_players' => $world->players->where('is_online', true)->count(),
                'created_at' => $world->created_at->format('M d, Y'),
            ];
        });

        return Inertia::render('Profile/Profile2', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_online' => $user->is_online,
                'created_at' => $user->created_at,
            ],
            'worldStats' => [
                'worldsOwned' => $worlds->count(),
                'totalPlayers' => $totalPlayers,
                'activePlayers' => $activePlayers,
            ],
            'worlds' => $worldDetails,
            'canEdit' => true,
        ]);
    }


   
    public function edit(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Profile/Edit2', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'is_online' => $user->is_online,
            ],
        ]);
    }

   
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'is_online' => 'required|boolean',
        ]);

        $user->forceFill([
            'name' => $request->name,
            'is_online' => $request->is_online,
        ])->save();

        return Redirect::route('world-owner.profile')->with('success', 'Profile updated successfully!');
    }
}
