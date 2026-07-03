<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('quests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('world_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->integer('reward_xp')->default(10);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
