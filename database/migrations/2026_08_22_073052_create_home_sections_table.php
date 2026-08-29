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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('title');
            $table->timestamps();
        });

        // Seed default sections
        DB::table('home_sections')->insert([
            ['key' => 'top_picks', 'title' => 'Top Picks for You', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'highly_rated', 'title' => 'Highly Rated Stays', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
