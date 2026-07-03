<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'max_players',
        'status',
        'background_image',
    ];
    public static $backgroundOptions = [
        'pale' => '/images/Minecraft_TheGardenAwakens_DotNet_1920x1080.png',
        'trial' => '/images/Minecraft_Trails&Tales_.Net_800x450.png',
        'boat' => '/images/wallpaper_minecraft_adventure_1920x1080.png',
        'bees' => '/images/wallpaper_minecraft_buzzybees_1920x1080.png',
        'jungle' => '/images/wallpaper_minecraft_cats_pandas_1920x1080.png',
        'caves' => '/images/wallpaper_minecraft_caves_cliffs(part2)_1920x1080.png',
        'island' => '/images/wallpaper_minecraft_island_1920x1080.png',
        'mangroves' => '/images/wallpaper_minecraft_mangroves_1920x1080.png',
        'mineshaft' => '/images/wallpaper_minecraft_mineshaft_1920x1080.png',
        'nether' => '/images/wallpaper_minecraft_nether_update_1920x1080.png',
        'ocean' => '/images/wallpaper_minecraft_ocean_monument_1920x1080.png',
        'default' => '/images/wallpaper_minecraft_pc_bundle_1920x1080.png',
        'aqua' => '/images/wallpaper_minecraft_update_aquatic_1920x1080.png',
        'village' => '/images/wallpaper_minecraft_village_pillage_1920x1080.png',
        'warden' => '/images/wallpaper_minecraft_warden_1920x1080.png',
        'wild' => '/images/wallpaper_minecraft_wild_update_1920x1080.png',

        // Add more as needed
    ];

    
    public function players()
    {
        return $this->belongsToMany(User::class, 'world_members')
            ->withPivot('role_in_world', 'is_kicked', 'is_blocked')
            ->wherePivot('is_kicked', false)
            ->wherePivot('is_blocked', false);
    }

   
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    
    public function quests()
    {
        return $this->hasMany(Quest::class);
    }
}
