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
        Schema::create('home_section_listing', function (Blueprint $table) {
            $table->id();
            $table->string('home_section_key');
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('home_section_key')->references('key')->on('home_sections')->cascadeOnDelete();
            $table->unique(['home_section_key', 'listing_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_section_listing');
    }
};
