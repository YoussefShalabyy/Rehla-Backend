<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('platform_settings')->updateOrInsert(
            ['key' => 'whatsapp_support'],
            [
                'value' => '+201000000000',
                'type' => 'string',
                'description' => 'WhatsApp Support Number (include + and country code)',
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
        DB::table('platform_settings')->where('key', 'whatsapp_support')->delete();
    }
};
