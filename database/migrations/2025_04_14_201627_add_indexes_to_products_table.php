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
        Schema::table('products', function (Blueprint $table) {
            $table->index('product_name', 'idx_product_name'); 
            $table->index('created_at', 'idx_created_at');
            $table->index('stock', 'idx_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_product_name');
            $table->dropIndex('idx_created_at');
            $table->dropIndex('idx_stock');
        });
    }
};
