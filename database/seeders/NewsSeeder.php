<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Lấy category con
        $thitruong = NewsCategory::where('slug', 'tin-tuc-thi-truong')->first();
        $quyhoach = NewsCategory::where('slug', 'tin-tuc-quy-hoach-vung')->first();

        /*
        |--------------------------------------------------------------------------
        | 1. Bài viết TIN TỨC THỊ TRƯỜNG (bài mẫu trong component của bạn)
        |--------------------------------------------------------------------------
        */
        News::create([
            'title' => 'XU HƯỚNG “BỎ PHỐ VỀ RỪNG”: SECOND HOME LÊN NGÔI MẠNH MẼ CUỐI 2025',
            'slug' => 'bo-pho-ve-rung-second-home-len-ngoi-2025',
            'excerpt' => 'Xu hướng “bỏ phố về rừng” đang trở thành lựa chọn sống và đầu tư phổ biến từ 2024–2025.',
            'thumbnail' => '/images/news/tintucthitruong-1.png',

            // gallery 6 ảnh giống component
            'gallery' => [
                '/images/news/tintucthitruong-1.png',
                '/images/news/tintucthitruong-2.png',
                '/images/news/tintucthitruong-3.png',
                '/images/news/tintucthitruong-1.png',
                '/images/news/tintucthitruong-2.png',
                '/images/news/tintucthitruong-3.png',
            ],

            'content' => <<<HTML
<p>Trong 2 năm trở lại đây, đặc biệt giai đoạn 2024–2025...</p>
<p>Mô hình second home tại các khu vực ven rừng...</p>

<h2>1. Vì sao “bỏ phố về rừng” trở thành xu hướng chủ đạo?</h2>
<p>Nếu như trước đây...</p>

<img src="/images/news/thiet-ke-nha-vuon-2000m2-32.png" />

<h2>2. Những mô hình second home đang lên ngôi</h2>
<p>Cabin gỗ, homestay ven hồ, farmstay...</p>
HTML,

            'author' => 'Admin',
            'category_id' => $thitruong->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Bài viết TIN TỨC QUY HOẠCH VÙNG
        |--------------------------------------------------------------------------
        */
        News::create([
            'title' => 'Quy hoạch vùng Nam Ban giai đoạn 2030 – Định hướng phát triển',
            'slug' => 'quy-hoach-vung-nam-ban-2030',
            'excerpt' => 'UBND tỉnh Lâm Đồng vừa phê duyệt quy hoạch mới...',
            'thumbnail' => '/images/news/tintucthitruong-2.png',
            'content' => fake()->paragraph(12),
            'author' => 'Admin',
            'gallery' => [],
            'category_id' => $quyhoach->id,
        ]);
    }
}
