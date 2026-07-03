<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\World;
use App\Models\User;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
        'title',
        'description',
        'reward_xp',
        'is_active',
    ];

   
    public function world()
    {
        return $this->belongsTo(World::class);
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('progress', 'is_completed')
                    ->withTimestamps();
    }
}
