<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Player;
use App\Models\World;
use App\Models\Quest;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_online', // Added this
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_online' => 'boolean', // Added this
        ];
    }

    public function player()
    {
        return $this->hasOne(Player::class);
    }

    public function worlds()
    {
        return $this->belongsToMany(World::class, 'world_members')
            ->withPivot('role_in_world', 'is_kicked', 'is_blocked')
            ->withTimestamps();
    }
    public function ownedWorlds()
    {
        return $this->hasMany(World::class, 'owner_id')
            ->withCount('players')
            ->latest();
    }
    public function totalPlayersInWorlds()
    {
        return DB::table('world_members')
            ->whereIn('world_id', $this->ownedWorlds()->pluck('id'))
            ->count();
    }

    public function activePlayersInWorlds()
    {
        return DB::table('world_members')
            ->whereIn('world_id', $this->ownedWorlds()->pluck('id'))
            ->where('is_active', true)
            ->count();
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class)
            ->withPivot('progress', 'is_completed')
            ->withTimestamps();
    }
}
