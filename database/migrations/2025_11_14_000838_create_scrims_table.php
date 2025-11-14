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
    Schema::create('scrims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Created By
        $table->string('scrim_name');
        $table->decimal('fee', 8, 2)->default(0);
        $table->string('rank')->nullable(); // e.g. #1, #2, #3
        $table->decimal('prize_pool', 10, 2)->default(0); // Prize pool for tracking
        $table->dateTime('match_time'); // Legacy 'time' column
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrims');
    }
};
