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
    Schema::create('worlds', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
        $table->integer('max_players')->default(10);
        $table->string('status')->default('open'); // open, full, closed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worlds');
    }
};
