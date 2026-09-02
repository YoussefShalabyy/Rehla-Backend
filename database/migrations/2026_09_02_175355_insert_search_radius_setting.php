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
        \Illuminate\Support\Facades\DB::table('platform_settings')->updateOrInsert(
            ['key' => 'search_radius'],
            [
                'value' => '50',
                'type' => 'integer',
                'description' => 'Default radius for nearby search in kilometers.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('platform_settings')->where('key', 'search_radius')->delete();
    }
};
