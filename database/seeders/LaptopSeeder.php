<?php

namespace Database\Seeders;

use App\Enums\LaptopStatus;
use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Database\Seeder;

class LaptopSeeder extends Seeder
{
    public function run(): void
    {
        $laptops = [
            ['Lenovo', 'ThinkPad T480', 'Intel Core i5-8350U', 'RAM 8GB / SSD 256GB', 4500000, 'Bodi kokoh, keyboard nyaman, cocok untuk kerja dan kuliah.'],
            ['Lenovo', 'ThinkPad X270', 'Intel Core i5-7300U', 'RAM 8GB / SSD 256GB', 3900000, 'Ringkas dan ringan, baterai tahan lama.'],
            ['Asus', 'VivoBook A412', 'Intel Core i3-1005G1', 'RAM 4GB / SSD 256GB', 3600000, 'Layar tipis 14 inci, harian ringan.'],
            ['Asus', 'ROG Strix G512', 'Intel Core i7-9750H', 'RAM 16GB / SSD 512GB', 9800000, 'Laptop gaming dengan GPU GTX 1650.'],
            ['Acer', 'Aspire 5 A514', 'AMD Ryzen 5 3500U', 'RAM 8GB / SSD 512GB', 4200000, 'Performa stabil untuk multitasking.'],
            ['HP', 'EliteBook 840 G5', 'Intel Core i7-8650U', 'RAM 16GB / SSD 512GB', 6200000, 'Laptop bisnis dengan bodi aluminium.'],
            ['Dell', 'Latitude 5490', 'Intel Core i5-8350U', 'RAM 8GB / SSD 256GB', 4300000, 'Tangguh, port lengkap.'],
            ['Apple', 'MacBook Air 2017', 'Intel Core i5 1.8GHz', 'RAM 8GB / SSD 128GB', 5800000, 'Ringan, baterai awet, macOS.'],
            ['Dell', 'Inspiron 3476', 'Intel Core i3-8130U', 'RAM 4GB / HDD 1TB', 2900000, 'Unit sudah terjual, dipakai sebagai contoh status.', LaptopStatus::Terjual],
        ];

        foreach ($laptops as $row) {
            [$brandName, $model, $processor, $ramStorage, $price, $description] = $row;

            $brand = Brand::firstOrCreate(['brand_name' => $brandName]);

            Laptop::firstOrCreate(
                ['brand_id' => $brand->id, 'model_name' => $model],
                [
                    'processor' => $processor,
                    'ram_storage' => $ramStorage,
                    'price' => $price,
                    'description' => $description,
                    'status' => $row[6] ?? LaptopStatus::Tersedia,
                ],
            );
        }
    }
}
