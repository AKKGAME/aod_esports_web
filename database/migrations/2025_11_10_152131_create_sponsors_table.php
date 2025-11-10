<?php
// database/migrations/..._create_sponsors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sponsor နာမည်
            $table->string('logo_url'); // ပုံ URL
            $table->string('website_url')->nullable(); // Link (မထည့်လည်း ရ)
            
            // (၁) "တစ်ခြား လိုအပ်တာတွေ"
            $table->string('level')->default('Partner'); // e.g., Title, Partner
            $table->boolean('is_active')->default(true); // ပြ/မပြ
            $table->integer('sort_order')->default(0); // အစဉ်လိုက် စီဖို့
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};