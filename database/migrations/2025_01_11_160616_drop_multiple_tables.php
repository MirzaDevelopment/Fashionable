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
            $table->dropForeign(['material_id']); // Drops the foreign key
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('material_id');
        });
        Schema::dropIfExists('products_types');

        // Drop the 'orders' table if it exists
        Schema::dropIfExists('category_types');

        // Drop the 'categories' table if it exists
        Schema::dropIfExists('materials');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
