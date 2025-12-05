<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Category cha
        $parent = NewsCategory::create([
            'name' => 'Tin tức',
            'slug' => 'tin-tuc',
            'parent_id' => null,
        ]);

        // Category con 1
        NewsCategory::create([
            'name' => 'Tin tức thị trường',
            'slug' => 'tin-tuc-thi-truong',
            'parent_id' => $parent->id,
        ]);

        // Category con 2
        NewsCategory::create([
            'name' => 'Tin tức quy hoạch vùng',
            'slug' => 'tin-tuc-quy-hoach-vung',
            'parent_id' => $parent->id,
        ]);
    }
}
