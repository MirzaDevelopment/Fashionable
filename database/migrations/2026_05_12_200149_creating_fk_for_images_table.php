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
        Schema::table('tenants', function (Blueprint $table) {

            $table->foreign('logo_image_id')
                ->references('id')
                ->on('category_images')
                ->nullOnDelete();

            $table->foreign('cover_image_id')
                ->references('id')
                ->on('category_images')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('tenants', function (Blueprint $table) {

            $table->dropForeign(['logo_image_id']);

            $table->dropForeign(['cover_image_id']);
        });
    }
};
