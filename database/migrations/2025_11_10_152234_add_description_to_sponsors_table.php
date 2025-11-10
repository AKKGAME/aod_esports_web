<?php
// database/migrations/..._add_description_to_sponsors_table.php

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
        Schema::table('sponsors', function (Blueprint $table) {
            // 'website_url' column ရဲ့ အနောက်မှာ 'description' column အသစ် ထပ်တိုးပါ
            $table->text('description')->nullable()->after('website_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            // ပြန်ဖျက်လိုပါက
            $table->dropColumn('description');
        });
    }
};