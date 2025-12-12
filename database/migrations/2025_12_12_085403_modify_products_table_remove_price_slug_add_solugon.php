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
            // Xóa unique index của cột slug trước khi xóa cột
            $table->dropUnique(['slug']);
            
            // Xóa cột price
            $table->dropColumn('price');
            
            // Xóa cột slug
            $table->dropColumn('slug');
            
            // Thêm cột solugon để hiển thị câu solugon cho dự án
            $table->text('solugon')->nullable()->after('short_description')->comment('Câu solugon cho dự án');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa cột solugon
            $table->dropColumn('solugon');
            
            // Thêm lại cột slug với unique
            $table->string('slug', 255)->unique()->after('name')->comment('Slug cho URL');
            
            // Thêm lại cột price
            $table->decimal('price', 15, 2)->default(0)->after('status')->comment('Giá sản phẩm');
        });
    }
};
