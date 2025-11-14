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
        Schema::create('scrim_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrim_id')->constrained('scrims')->onDelete('cascade'); // Scrim နှင့် ချိတ်ဆက်
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade'); // Player နှင့် ချိတ်ဆက်
            
            // Stats Fields
            $table->string('Map')->nullable();
            $table->integer('Kill')->default(0);
            $table->integer('Assists')->default(0);
            $table->integer('Damage')->default(0);
            $table->integer('Heals')->default(0);
            $table->integer('Survival_Time')->default(0); // in seconds
            $table->string('Desc')->nullable(); // Optional notes
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrim_details');
    }
};
