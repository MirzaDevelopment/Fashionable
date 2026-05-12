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

            // Remove old string columns
            $table->dropColumn(['logo', 'cover_image']);

            // Add image ID columns
            $table->unsignedBigInteger('logo_image_id')
                ->nullable()
                ->after('slug');

            $table->unsignedBigInteger('cover_image_id')
                ->nullable()
                ->after('logo_image_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
               Schema::table('tenants', function (Blueprint $table) {

            // Drop new columns
            $table->dropColumn([
                'logo_image_id',
                'cover_image_id',
            ]);

            // Restore old columns
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
        });
    }
};
