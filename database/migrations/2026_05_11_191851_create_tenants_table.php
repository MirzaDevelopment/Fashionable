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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Shop name
            $table->string('slug')->unique(); // URL slug

            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();

            $table->string('currency', 3)->default('EUR');
            // EUR, BAM, RSD etc.

            $table->string('locale')->default('bs');
            // bs, hr, sr, en

            $table->string('email')->nullable();
            $table->string('phone')->nullable();


            $table->string('shipping_provider')->nullable();
            // BH Post, EuroExpress, A2B, DHL etc.

            $table->decimal('shipping_cost', 10, 2)->nullable();

            $table->decimal('free_shipping_threshold', 10, 2)
                ->nullable();


            $table->string('plan')->default('free');

            $table->timestamp('trial_ends_at')->nullable();


            $table->boolean('is_active')->default(true);

            $table->timestamp('suspended_at')->nullable();



            $table->json('settings')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
