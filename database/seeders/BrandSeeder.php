<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Lenovo', 'Asus', 'Acer', 'HP', 'Dell', 'Apple'];

        foreach ($brands as $name) {
            Brand::firstOrCreate(['brand_name' => $name]);
        }
    }
}
