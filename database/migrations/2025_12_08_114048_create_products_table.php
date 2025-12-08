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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('restrict')->comment('Loại sản phẩm');
            $table->string('name', 255)->comment('Tên sản phẩm');
            $table->string('slug', 255)->unique()->comment('Slug cho URL');
            $table->text('short_description')->nullable()->comment('Mô tả ngắn');
            $table->enum('status', ['Đang bán', 'Đã bán', 'Hot', 'Sắp mở bán'])->default('Đang bán')->comment('Trạng thái sản phẩm');
            $table->decimal('price', 15, 2)->default(0)->comment('Giá sản phẩm');
            $table->timestamps();
            
            $table->index('product_type_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
