<?php

namespace Database\Factories;

use App\Enums\LaptopStatus;
use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Laptop> */
class LaptopFactory extends Factory
{
    protected $model = Laptop::class;

    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'model_name' => fake()->unique()->bothify('Model ??-####'),
            'processor' => fake()->randomElement(['Intel Core i5-8250U', 'Intel Core i7-8550U', 'AMD Ryzen 5 3500U']),
            'ram_storage' => fake()->randomElement(['RAM 8GB / SSD 256GB', 'RAM 16GB / SSD 512GB', 'RAM 4GB / HDD 500GB']),
            'price' => fake()->numberBetween(25, 150) * 100000,
            'image' => null,
            'status' => LaptopStatus::Tersedia,
            'description' => fake()->sentence(),
        ];
    }

    public function status(LaptopStatus $status): static
    {
        return $this->state(fn () => ['status' => $status]);
    }
}
