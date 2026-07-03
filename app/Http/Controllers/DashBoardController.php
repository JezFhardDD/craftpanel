<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\Quest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Player;


class DashboardController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'World Owner') {
            return redirect()->route('world-owner.dashboard');
        }

        return redirect()->route('player.dashboard');
    }

    public function player()
    {
        $user = Auth::user();

        return Inertia::render('PlayerDashboard', [
            'user' => $user,
            'playerStats' => [
                'level' => $user->player->level,
                'xp_points' => $user->player->xp_points,
                'friends_count' => $user->player->friends_count,
                'kills_pvp' => $user->player->kills_pvp,
                'kills_pve' => $user->player->kills_pve,
                'achievements_unlocked' => $user->player->achievements_unlocked,
            ],
            'joinedWorlds' => $user->worlds()->with(['owner', 'players'])->get()->map(function ($world) {
                return [
                    'id' => $world->id,
                    'name' => $world->name,
                    'max_players' => $world->max_players,
                    'players_count' => $world->players->count(),
                    'owner' => [
                        'name' => $world->owner->name,
                    ],
                ];
            }),

            'activeQuests' => $user->quests()
                ->where('is_completed', false)
                ->with('world')
                ->get()
                ->map(function ($quest) {
                    return [
                        'id' => $quest->id,
                        'title' => $quest->title,
                        'description' => $quest->description,
                        'reward_xp' => $quest->reward_xp,
                        'progress' => $quest->pivot->progress,
                        'world_name' => $quest->world->name,
                    ];
                }),
            'leaderboard' => Player::query()
                ->orderByDesc('level')
                ->orderByDesc('xp_points')
                ->limit(10)
                ->with('user')
                ->get()
                ->map(function ($player) {
                    return [
                        'id' => $player->user->id,
                        'name' => $player->user->name,
                        'level' => $player->level,
                        'xp_points' => $player->xp_points,
                        'kills_pvp' => $player->kills_pvp,
                        'kills_pve' => $player->kills_pve,
                    ];
                }),
        ]);
    }

    public function worldOwner()
    {
        $user = Auth::user();

        return Inertia::render('WorldOwnerDashboard', [
            'user' => $user,
            'ownedWorlds' => World::where('owner_id', $user->id)
                ->withCount(['players as players_count' => function ($query) {
                    $query->where('is_kicked', false)->where('is_blocked', false);
                }])
                ->get()
                ->map(function ($world) {
                    return [
                        'id' => $world->id,
                        'name' => $world->name,
                        'status' => $world->status,
                        'max_players' => $world->max_players,
                        'players_count' => $world->players_count,
                    ];
                }),
            'otherWorlds' => World::where('owner_id', '!=', $user->id)
                ->with('owner')
                ->withCount(['players as players_count' => function ($query) {
                    $query->where('is_kicked', false)->where('is_blocked', false);
                }])
                ->get()
                ->map(function ($world) {
                    return [
                        'id' => $world->id,
                        'name' => $world->name,
                        'max_players' => $world->max_players,
                        'players_count' => $world->players_count,
                        'owner' => [
                            'name' => $world->owner->name,
                        ],
                    ];
                }),
            'leaderboard' => Player::query()
                ->orderByDesc('level')
                ->orderByDesc('xp_points')
                ->limit(10)
                ->with('user')
                ->get()
                ->map(function ($player) {
                    return [
                        'id' => $player->user->id,
                        'name' => $player->user->name,
                        'level' => $player->level,
                        'xp_points' => $player->xp_points,
                        'kills_pvp' => $player->kills_pvp,
                        'kills_pve' => $player->kills_pve,
                    ];
                }),
        ]);
    }

    public function admin()
    {
        return Inertia::render('AdminDashboard', [
            'user' => Auth::user()
        ]);
    }
}