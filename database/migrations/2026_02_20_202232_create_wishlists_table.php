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
        Schema::create('wishlists', function (Blueprint $table) {
 $table->id();

        // Relationships
        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('product_id')
              ->constrained()
              ->cascadeOnDelete();

        // Track price at time of adding (important for discount detection)
        $table->decimal('price_when_added', 10, 2)->nullable();

        // Track if we've already notified them
        $table->boolean('notified_of_discount')->default(false);

        $table->timestamps();

        // Prevent duplicates
        $table->unique(['user_id', 'product_id']);

        // Helpful indexes for discount queries
        $table->index('product_id');
        $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
