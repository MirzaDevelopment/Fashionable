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

    Schema::dropIfExists('products_sizes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('products_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onUpdate('restrict');
            $table->foreignId('category_size_id')->constrained()->onDelete('cascade')->onUpdate('restrict');
            $table->timestamps();
           
        });
    }
};
