<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
        ];

        
        if ($user->role === 'Player') {
            $data['playerStats'] = $user->player;
        }
-
        $data['userRole'] = $user->role;

        return Inertia::render('About', $data);
    }
}