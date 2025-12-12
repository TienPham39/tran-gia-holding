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
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột is_highlight để đánh dấu sản phẩm nổi bật
            $table->boolean('is_highlight')->default(false)->after('status')->comment('Sản phẩm nổi bật');
            
            // Thêm index cho is_highlight để tìm kiếm nhanh
            $table->index('is_highlight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa index trước khi xóa cột
            $table->dropIndex(['is_highlight']);
            
            // Xóa cột is_highlight
            $table->dropColumn('is_highlight');
        });
    }
};
