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
        Schema::table('category_images', function (Blueprint $table) {
            $table->string('image_200x200')->after('image_path');
            $table->string('image_400x400')->after('image_200x200');
            $table->string('image_800x800')->after('image_400x400');
            $table->string('image_1200x1200')->after('image_800x800');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_images', function (Blueprint $table) {
        $table->dropColumn(['image_200x200', 'image_400x400', 'image_800x800', 'image_1200x1200']);
        });
    }
};
