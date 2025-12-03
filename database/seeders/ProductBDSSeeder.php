<?php

namespace Database\Seeders;
use App\Models\ProductBDS;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBDSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [];

        for ($i = 1; $i <= 10; $i++) {
            $samples[] = [
                'title' => 'Dự án Demo ' . $i,
                'image' => '/images/sample' . (($i % 3) + 1) . '.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                'price' => rand(900, 5000) * 1000000,
                'location' => 'Phường ' . rand(1, 12) . ', Đà Lạt',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProductBDS::insert($samples);
    }
}
