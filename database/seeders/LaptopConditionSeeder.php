<?php

namespace Database\Seeders;

use App\Models\Laptop;
use App\Models\LaptopCondition;
use Illuminate\Database\Seeder;

/**
 * Data demo inspeksi. Tiga laptop sengaja dibiarkan belum diinspeksi
 * (Aspire 5 A514, MacBook Air 2017, Inspiron 3476) supaya form tambah inspeksi bisa didemokan.
 */
class LaptopConditionSeeder extends Seeder
{
    public function run(): void
    {
        $inspections = [
            // 'Nama model' => [baterai, layar, keyboard, catatan minus]
            'ThinkPad T480' => ['85%', 'Mulus, tanpa dead pixel', 'Semua tombol normal', null],
            'ThinkPad X270' => ['78%', 'Ada goresan halus di pojok kanan bawah', 'Normal', 'Engsel sedikit longgar.'],
            'VivoBook A412' => ['90%', 'Mulus', 'Normal, backlight berfungsi', null],
            'ROG Strix G512' => ['70%', 'Mulus, refresh rate normal', 'RGB menyala semua', 'Kipas agak berisik saat beban berat.'],
            'EliteBook 840 G5' => ['82%', 'Mulus', 'Normal', 'Ada baret tipis di casing.'],
            'Latitude 5490' => ['75%', 'Mulus', 'Tombol spasi agak keras', null],
        ];

        foreach ($inspections as $modelName => [$battery, $screen, $keyboard, $minusNote]) {
            $laptop = Laptop::where('model_name', $modelName)->first();

            if (! $laptop) {
                continue;
            }

            // updateOrCreate: aman dijalankan berulang kali, tidak bikin data dobel
            LaptopCondition::updateOrCreate(
                ['laptop_id' => $laptop->id],
                [
                    'battery_health' => $battery,
                    'screen_condition' => $screen,
                    'keyboard_status' => $keyboard,
                    'minus_note' => $minusNote,
                ],
            );
        }
    }
}
