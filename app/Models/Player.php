<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'xp_points',
        'friends_count', 
        'items_owned',
        'kills_pvp',
        'kills_pve',
        'achievements_unlocked',
    ];
    protected $touches = ['user'];
     protected $casts = [
        'level' => 'integer',
        'xp_points' => 'integer',
        'friends_count' => 'integer',
        'items_owned' => 'integer',
        'kills_pvp' => 'integer',
        'kills_pve' => 'integer',
        'achievements_unlocked' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
