<?php
// database/migrations/...._add_details_to_teams_table.php

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
        Schema::table('teams', function (Blueprint $table) {
            // (၁) 'name' column ရဲ့ အနောက်မှာ 'logo_url' ကို ထည့်ပါ
            $table->string('logo_url')->nullable()->after('name');
            
            // (၂) 'logo_url' column ရဲ့ အနောက်မှာ 'description' ကို ထည့်ပါ
            $table->text('description')->nullable()->after('logo_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // (၃) ပြန်ဖျက်လိုပါက 
            $table->dropColumn(['logo_url', 'description']);
        });
    }
};