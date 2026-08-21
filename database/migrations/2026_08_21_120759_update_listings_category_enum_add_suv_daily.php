<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Null out any existing 'family' values so the enum change won't fail
        DB::statement("UPDATE listings SET category = NULL WHERE category = 'family'");
        // Step 2: Alter the enum column to the new allowed values
        DB::statement("ALTER TABLE listings MODIFY COLUMN category ENUM('luxury','sports','suv','economy','daily') NULL");
        // Step 3: Remap the nulled rows (formerly 'family') to 'suv'
        DB::statement("UPDATE listings SET category = 'suv' WHERE category IS NULL AND type = 'car'");
    }

    public function down(): void
    {
        // Revert 'suv' back to 'family' before shrinking the enum
        DB::statement("UPDATE listings SET category = 'family' WHERE category = 'suv'");
        DB::statement("ALTER TABLE listings MODIFY COLUMN category ENUM('luxury','sports','family','economy') NULL");
    }
};
