<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactCategory;

class ContactCategorySeeder extends Seeder
{
    public function run(): void
    {
        ContactCategory::insert([
            [
                'name' => 'Tư vấn bất động sản',
                'code' => 'real_estate',
                'description' => 'Khách hàng liên hệ tư vấn dự án, mua bán bất động sản',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tuyển dụng',
                'code' => 'recruitment',
                'description' => 'Ứng viên gửi hồ sơ ứng tuyển',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
