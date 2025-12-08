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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->comment('Sản phẩm');
            $table->longText('description')->nullable()->comment('Mô tả chi tiết');
            $table->decimal('area', 10, 2)->nullable()->comment('Diện tích');
            $table->integer('bedrooms')->nullable()->comment('Số phòng ngủ');
            $table->integer('bathrooms')->nullable()->comment('Số phòng tắm');
            $table->timestamps();
            
            $table->unique('product_id'); // 1 product chỉ có 1 detail
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
