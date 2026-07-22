<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ] : [
                'id' => null,
                'name' => 'Guest',
                'role' => null,
            ],
            'playerStats' => null,
            'userRole' => $user?->role,
        ];

        if ($user?->role === 'Player' && $user->player) {
            $data['playerStats'] = $user->player;
        }

        return Inertia::render('About', $data);
    }
}