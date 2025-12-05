<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {

            // 1. Xóa cột category ENUM cũ
            if (Schema::hasColumn('news', 'category')) {
                $table->dropColumn('category');
            }

            // 2. Thêm cột gallery nếu chưa có
            if (!Schema::hasColumn('news', 'gallery')) {
                $table->json('gallery')->nullable()->after('content');
            }
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            // Khôi phục lại nếu cần rollback
            $table->enum('category', ['market', 'planning'])->default('market');
            $table->dropColumn('gallery');
        });
    }
};
