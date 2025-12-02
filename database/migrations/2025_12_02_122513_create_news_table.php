<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            // Thumbnail image
            $table->string('thumbnail')->nullable();

            // short description (to show in list)
            $table->string('excerpt')->nullable();

            // full content (page detail)
            $table->longText('content')->nullable();

            // Loại tin: market / planning
            $table->enum('category', ['market', 'planning'])
                ->default('market')
                ->index();

            // Optional fields
            $table->string('author')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
