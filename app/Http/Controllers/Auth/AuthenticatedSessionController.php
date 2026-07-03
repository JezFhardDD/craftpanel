<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();
        
        // Redirect based on role
        if ($user->role === 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'World Owner') {
            return redirect()->intended(route('world-owner.dashboard'));
        }
        
        return redirect()->intended(route('player.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the post-login redirect path based on user role.
     * (This is now handled directly in the store method)
     */
    protected function redirectTo()
    {
        // This method is not needed anymore since we're handling redirects in store()
        // But kept for compatibility if referenced elsewhere
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'World Owner') {
            return route('world-owner.dashboard');
        }
        
        return route('player.dashboard');
    }
}