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
    Schema::create('players', function (Blueprint $table) {
        $table->id();
        $table->string('ign'); // In-Game Name
        $table->string('real_name')->nullable();
        $table->string('role')->nullable();
        $table->string('status')->default('Player');
        $table->string('photo_url')->nullable();
        
        // Team နဲ့ ချိတ်ဆက်ဖို့ Foreign Key
        $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();

        $table->string('country_code', 5)->nullable(); // e.g., MM
        $table->date('join_date')->nullable();
        $table->decimal('salary', 15, 2)->default(0);
        $table->text('bio')->nullable();
        
        // Social URLs
        $table->string('facebook_url')->nullable();
        $table->string('youtube_url')->nullable();
        $table->string('tiktok_url')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
