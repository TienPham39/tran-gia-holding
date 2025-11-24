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
        Schema::create('productbds', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('image')->nullable();  // link ảnh
            $table->longText('description')->nullable();
            $table->decimal('price', 15, 2)->nullable(); // giá BĐS
            $table->string('location')->nullable(); // vị trí
            $table->string('status')->default('active'); // trạng thái: active/inactive/new

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productbds');
    }
};
