<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return Inertia::render('About', [
                'user' => [
                    'id' => null,
                    'name' => 'Guest',
                    'role' => null,
                ],
                'playerStats' => null,
                'userRole' => null,
            ]);
        }

        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ],
            'playerStats' => null,
            'userRole' => $user->role,
        ];

        if ($user->role === 'Player' && $user->player) {
            $data['playerStats'] = $user->player;
        }

        return Inertia::render('About', $data);
    }
}