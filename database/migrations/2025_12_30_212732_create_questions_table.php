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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('user_name'); // Column for user name
            $table->string('user_email'); // Column for user email
            $table->text('question'); // Column for the question text
            $table->enum('status', ['answered', 'unanswered'])->default('unanswered'); // Status column with possible values
            $table->timestamps(); // Creates 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
