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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('scope_type', ['global', 'listing_type', 'property_type', 'listing'])->default('global');
            $table->string('scope_value')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed_amount']);
            $table->unsignedInteger('discount_amount')->comment('Cents for fixed, 1-100 for percentage');
            $table->unsignedInteger('max_discount_amount')->nullable()->comment('Cents cap for percentage discounts');
            $table->unsignedInteger('min_checkout_amount')->nullable()->comment('Minimum required cents in total price');
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['code', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
