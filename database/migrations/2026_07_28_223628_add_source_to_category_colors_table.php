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
        Schema::table('category_colors', function (Blueprint $table) {
            $table->enum('source', ['default', 'user'])
                ->nullable()
                ->after('id'); // Adjust the position as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_colors', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
