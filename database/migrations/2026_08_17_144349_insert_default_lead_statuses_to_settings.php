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
        DB::table('platform_settings')->insert([
            'key' => 'lead_statuses',
            'value' => json_encode(['pending', 'contacted', 'booked', 'lost']),
            'type' => 'json',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('platform_settings')->where('key', 'lead_statuses')->delete();
    }
};
