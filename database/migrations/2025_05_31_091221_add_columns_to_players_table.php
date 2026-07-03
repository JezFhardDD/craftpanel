<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('xp_points')->default(0);
            $table->unsignedInteger('friends_count')->default(0);
            $table->unsignedInteger('items_owned')->default(0);
            $table->unsignedInteger('kills_pvp')->default(0);
            $table->unsignedInteger('kills_pve')->default(0);
            $table->unsignedInteger('achievements_unlocked')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn([
                'level',
                'xp_points',
                'friends_count',
                'items_owned',
                'kills_pvp',
                'kills_pve',
                'achievements_unlocked',
            ]);
        });
    }
};
