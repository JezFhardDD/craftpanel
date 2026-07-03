<?php

use App\Http\Controllers\{
    AboutController,
    DashboardController,
    ProfileController,
    ProfileController2,
    WorldController
};
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/worlds', [WorldController::class, 'index'])->name('worlds.index');
Route::get('/worlds/{world}', [WorldController::class, 'show'])->name('worlds.show');

// Authentication Routes
require __DIR__ . '/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');
    Route::get('/player-dashboard', [DashboardController::class, 'player'])->name('player.dashboard');
    Route::get('/world-owner-dashboard', [DashboardController::class, 'worldOwner'])->name('world-owner.dashboard');
    Route::get('/admin-dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // World Owner Profile Routes
    Route::middleware('role:World Owner')->prefix('world-owner/profile')->group(function () {
        Route::get('/', [ProfileController2::class, 'show'])->name('world-owner.profile');
        Route::get('/edit', [ProfileController2::class, 'edit'])->name('world-owner.profile.edit');
        Route::patch('/', [ProfileController2::class, 'update'])->name('world-owner.profile.update');
    });

    // World Management Routes
    Route::prefix('worlds')->group(function () {
        // Public world routes (viewing)
        Route::get('/worlds/create', [WorldController::class, 'create'])->name('worlds.create');
        Route::post('/', [WorldController::class, 'store'])->name('worlds.store');

        // World Owner protected routes
        Route::middleware('role:World Owner')->group(function () {
            Route::prefix('{world}')->group(function () {
                Route::get('/manage', [WorldController::class, 'manage'])->name('worlds.manage');
                Route::get('/edit', [WorldController::class, 'edit'])->name('worlds.edit');
                Route::patch('/', [WorldController::class, 'update'])->name('worlds.update');
                Route::delete('/', [WorldController::class, 'destroy'])->name('worlds.destroy');

                // Player Management
                Route::prefix('players')->group(function () {
                    Route::post('/kick/{user}', [WorldController::class, 'kickPlayer'])->name('worlds.players.kick');
                    Route::post('/ban/{user}', [WorldController::class, 'banPlayer'])->name('worlds.players.ban');
                    Route::post('/unban/{user}', [WorldController::class, 'unbanPlayer'])->name('worlds.players.unban');
                });

                // Quest Management
                Route::prefix('quests')->group(function () {
                    Route::post('/', [WorldController::class, 'storeQuest'])->name('worlds.quests.store');
                    Route::patch('/{quest}', [WorldController::class, 'updateQuest'])->name('worlds.quests.update');
                    Route::delete('/{quest}', [WorldController::class, 'destroyQuest'])->name('worlds.quests.destroy');
                });
            });
        });

        // Player Routes
        Route::middleware('role:Player')->prefix('{world}')->group(function () {
            Route::post('/join', [WorldController::class, 'join'])->name('worlds.join');
            Route::post('/leave', [WorldController::class, 'leave'])->name('worlds.leave');

            Route::prefix('quests/{quest}')->group(function () {
          Route::post('/acquire', [WorldController::class, 'acquireQuest'])->name('worlds.quests.acquire');
          Route::post('/complete', [WorldController::class, 'completeQuest'])->name('worlds.quests.complete');
          Route::post('/leave', [WorldController::class, 'leaveQuest'])->name('worlds.quests.leave');
      });
        });
    });
});