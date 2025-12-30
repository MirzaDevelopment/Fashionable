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
    // Rename product_colors to products_colors
    Schema::rename('product_colors', 'products_colors');
    Schema::rename('product_genders','products_genders');
    Schema::rename('product_sizes', 'products_sizes');
    Schema::rename('product_types', 'products_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('products_colors', 'product_colors');
        Schema::rename('products_genders', 'product_genders');
        Schema::rename('products_sizes', 'product_sizes');
        Schema::rename('products_types', 'product_types');
    }
};
