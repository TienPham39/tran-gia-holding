<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Xóa cột cũ (đường dẫn file)
            if (Schema::hasColumn('news', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }

            if (Schema::hasColumn('news', 'gallery')) {
                $table->dropColumn('gallery');
            }

            // Thêm cột Base64
            $table->longText('thumbnail_base64')->nullable()->after('slug');
            $table->longText('gallery_base64')->nullable()->after('thumbnail_base64');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Khôi phục cột cũ
            $table->string('thumbnail')->nullable()->after('slug');
            $table->json('gallery')->nullable()->after('thumbnail');

            // Xóa cột Base64
            $table->dropColumn('thumbnail_base64');
            $table->dropColumn('gallery_base64');
        });
    }
};
