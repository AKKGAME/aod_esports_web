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
    Schema::table('scrims', function (Blueprint $table) {
        // (အရေးကြီး) Foreign Key Constraint ကို အရင်ဖျက်ပါ
        $table->dropForeign(['user_id']);
        // Column ကို ဖျက်ပါ
        $table->dropColumn('user_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scrims', function (Blueprint $table) {
            //
        });
    }
};
