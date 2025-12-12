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
        Schema::table('product_images', function (Blueprint $table) {
            // Thêm cột image_type để phân loại ảnh (thumbnail, gallery, banner, etc.)
            $table->string('image_type', 50)->nullable()->after('image_url')->comment('Loại ảnh');
            
            // Thêm index cho image_type để tìm kiếm nhanh
            $table->index('image_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Xóa index trước khi xóa cột
            $table->dropIndex(['image_type']);
            
            // Xóa cột image_type
            $table->dropColumn('image_type');
        });
    }
};
