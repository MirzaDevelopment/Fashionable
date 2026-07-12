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
            $table->string('image_320x320')->nullable()->change();
            $table->string('image_400x400')->nullable()->change();
            $table->string('image_800x800')->nullable()->change();
            $table->string('image_1200x1200')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_images', function (Blueprint $table) {
            $table->string('image_320x320')->nullable(false)->change();
            $table->string('image_400x400')->nullable(false)->change();
            $table->string('image_800x800')->nullable(false)->change();
            $table->string('image_1200x1200')->nullable(false)->change();
        });
    }
};
