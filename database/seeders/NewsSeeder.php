<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Tin tức thị trường
        News::create([
            'title' => 'Giá nhà đất Lâm Hà 2024 có nhiều biến động tích cực',
            'excerpt' => 'Thị trường bất động sản Lâm Hà ghi nhận mức tăng trưởng mạnh...',
            'content' => fake()->paragraph(10),
            'thumbnail' => '/images/news/default1.png',
            'category' => 'market'
        ]);

        // Tin tức quy hoạch vùng
        News::create([
            'title' => 'Quy hoạch vùng Nam Ban giai đoạn 2030 – Định hướng phát triển',
            'excerpt' => 'UBND tỉnh Lâm Đồng vừa phê duyệt quyết định quy hoạch mới...',
            'content' => fake()->paragraph(10),
            'thumbnail' => '/images/news/default2.png',
            'category' => 'planning'
        ]);

        News::factory()->count(10)->create();
    }
}
