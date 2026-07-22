<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\World;
use App\Models\Quest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class WorldController extends Controller
{
    use AuthorizesRequests;
    // Background options (could also be moved to config/world.php)
    public static $backgroundOptions = [
        'default' => '/images/worlds/default.jpg',
        'forest' => '/images/worlds/forest.jpg',
        'nether' => '/images/worlds/nether.jpg',
        'end' => '/images/worlds/end.jpg',
        'desert' => '/images/worlds/desert.jpg',
    ];

    /**
     * Display a listing of all worlds (for players to join or view).
     */
    public function index()
{
    $user = Auth::user();

    $worlds = World::query()
        ->withCount('players')
        ->with('owner')
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get();

    $joinedWorldIds = $user->worlds()->pluck('world_id')->toArray();

    return Inertia::render('Worlds/Index', [
        'worlds' => $worlds->map(function ($world) {
            return [
                'id' => $world->id,
                'name' => $world->name,
                'max_players' => $world->max_players,
                'players_count' => $world->players_count,
                'owner_name' => $world->owner->name ?? 'Unknown',
                'background_image' => $world->background_image,
                'created_at' => $world->created_at->diffForHumans(),
            ];
        }),
        'joinedWorldIds' => $joinedWorldIds,
    ]);
}
public function acquireQuest(Request $request, World $world, Quest $quest)
{
    $user = $request->user();

    // Ensure the quest belongs to this world
    if ($quest->world_id !== $world->id) {
        abort(403, 'This quest does not belong to this world.');
    }

    // Prevent duplicates
    if ($user->quests()->where('quest_id', $quest->id)->exists()) {
        return back()->with('error', 'You already joined this quest.');
    }

    $user->quests()->attach($quest->id, [
        'progress' => 0,
        'is_completed' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Quest joined successfully!');
}



    /**
     * Show the form for creating a new world.
     */
    public function create()
    {
        $this->authorize('create', World::class);

        return Inertia::render('Worlds/Create', [
            'backgroundOptions' => World::$backgroundOptions,
            'user' => auth()->user(),
            'defaultValues' => [
                'name' => '',
                'max_players' => 10,
                'status' => 'active',
                'background_image' => 'default',
            ]
        ]);
    }
    public function storeQuest(Request $request, World $world)
    {
        if ($world->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reward_xp' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $world->quests()->create($validated);

        return redirect()->back()->with('success', 'Quest created successfully');
    }
    public function updateQuest(Request $request, World $world, Quest $quest)
    {
        if ($world->owner_id !== $request->user()->id || $quest->world_id !== $world->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'reward_xp' => 'sometimes|required|integer|min:1',
            'is_active' => 'sometimes|boolean'
        ]);

        $quest->update($validated);

        return redirect()->back()->with('success', 'Quest updated successfully');
    }
    public function destroyQuest(Request $request, World $world, Quest $quest)
    {
        if ($world->owner_id !== $request->user()->id || $quest->world_id !== $world->id) {
            abort(403, 'Unauthorized');
        }

        $quest->delete();

        return redirect()->back()->with('success', 'Quest deleted successfully');
    }


    /**
     * Store a newly created world in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', World::class);

        // Validate input
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:worlds,name',
                'regex:/^[a-zA-Z0-9\s\-_]+$/' // Only allow alphanumeric, spaces, hyphens, and underscores
            ],
            'max_players' => [
                'required',
                'integer',
                'min:1',
                'max:50'
            ],
            'status' => [
                'required',
                'in:active,maintenance,inactive'
            ],
            'background_image' => [
                'required',
                'in:' . implode(',', array_keys(World::$backgroundOptions))
            ]
        ]);

        // Create the world within a transaction for safety
        $world = DB::transaction(function () use ($validated) {
            return World::create([
                'name' => $validated['name'],
                'max_players' => $validated['max_players'],
                'status' => $validated['status'],
                'background_image' => $validated['background_image'], // Store the key, not the full path
                'owner_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        // Optionally: Create default roles/permissions for this world
        // $this->createDefaultWorldRoles($world);

        return redirect()
            ->route('worlds.show', $world)
            ->with([
                'success' => 'World created successfully!',
                'world' => $world // Pass the world object to the view if needed
            ]);
    }

    /**
     * Display the specified world.
     */
    public function show(World $world)
    {
        $user = auth()->user();
        $world->load(['owner', 'players', 'quests.users']);

        $isMember = $user ? $world->players->contains($user) : false;
        $isOwner = $user ? $world->owner_id === $user->id : false;

        return Inertia::render('Worlds/World2', [
            'world' => $world,
            'isMember' => $isMember,
            'isOwner' => $isOwner,
            'auth' => $user,
        ]);
    }


    /**
     * Get available background options (API endpoint)
     */
    public function getBackgroundOptions()
    {
        return response()->json([
            'backgrounds' => self::$backgroundOptions
        ]);
    }
    public function edit(World $world)
    {
        $this->authorize('update', $world);

        return Inertia::render('Worlds/Edit', [
            'world' => $world,
            'backgroundOptions' => self::$backgroundOptions,
        ]);
    }
    public function update(Request $request, World $world)
    {
        $this->authorize('update', $world);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:worlds,name,' . $world->id,
            'max_players' => 'required|integer|min:1|max:50',
            'status' => 'required|in:active,maintenance,inactive',
            // Remove background_image validation since your form doesn't send it
        ]);

        $world->update([
            'name' => $validated['name'],
            'max_players' => $validated['max_players'],
            'status' => $validated['status'],
            // Don't update background_image if not in form
        ]);

        return redirect()
            ->route('worlds.manage', $world) // Redirect back to manage page
            ->with('success', 'World updated successfully!');
    }
    public function destroy(World $world)
    {
        $this->authorize('delete', $world);

        $world->delete();

        return redirect()
            ->route('world-owner.dashboard')
            ->with('success', 'World deleted successfully!');
    }
    public function manage(Request $request, World $world)
    {
        // Ensure the user owns this world
        if ($world->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Load world with all necessary relationships
        $world->load([
            'players' => function ($query) {
                $query->withPivot('role_in_world', 'is_kicked', 'is_blocked', 'created_at')
                    ->where('world_members.is_kicked', false)
                    ->where('world_members.is_blocked', false);
            },
            'quests' => function ($query) {
                $query->withCount('users')
                    ->with(['users' => function ($userQuery) {
                        $userQuery->withPivot('progress', 'is_completed');
                    }]);
            }
        ]);

        return Inertia::render('World', [
            'world' => [
                'id' => $world->id,
                'name' => $world->name,
                'status' => $world->status,
                'max_players' => $world->max_players,
                'current_players' => $world->players->count(),
                'created_at' => $world->created_at,
                'players' => $world->players,
                'quests' => $world->quests->map(function ($quest) {
                    return [
                        'id' => $quest->id,
                        'title' => $quest->title,
                        'description' => $quest->description,
                        'reward_xp' => $quest->reward_xp,
                        'is_active' => $quest->is_active,
                        'users_count' => $quest->users_count,
                        'users' => $quest->users,
                        'created_at' => $quest->created_at,
                    ];
                })
            ]
        ]);
    }
    public function join(Request $request, World $world)
    {
        $user = Auth::user();

        if ($world->players()->count() >= $world->max_players) {
            return back()->with('error', 'World is full!');
        }

        if ($world->players()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already in this world!');
        }

        $world->players()->attach($user->id); // 🔁 FIX: removed joined_at

        return back()->with('success', 'Successfully joined the world!');
    }

    public function leave(Request $request, World $world)
    {
        $user = Auth::user();

        $world->players()->detach($user->id);

        return back()->with('success', 'Successfully left the world!');
    }
    public function kickPlayer(Request $request, World $world, User $user)
    {
        if ($world->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        $world->players()->updateExistingPivot($user->id, [
            'is_kicked' => true
        ]);

        return redirect()->back()->with('success', 'Player kicked successfully');
    }

    public function banPlayer(Request $request, World $world, User $user)
    {
        if ($world->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        $world->players()->updateExistingPivot($user->id, [
            'is_blocked' => true,
            'is_kicked' => true
        ]);

        return redirect()->back()->with('success', 'Player banned successfully');
    }
    public function unbanPlayer(Request $request, World $world, User $user)
    {
        if ($world->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        $world->players()->updateExistingPivot($user->id, [
            'is_blocked' => false,
            'is_kicked' => false
        ]);

        return redirect()->back()->with('success', 'Player unbanned successfully');
    }
    public function leaveQuest(Request $request, World $world, Quest $quest)
{
    $user = $request->user();

    // Ensure the quest belongs to this world
    if ($quest->world_id !== $world->id) {
        abort(403, 'This quest does not belong to the specified world.');
    }

    // Detach the user from the quest
    $user->quests()->detach($quest->id);

    return back()->with('success', 'You have left the quest.');
}
}
