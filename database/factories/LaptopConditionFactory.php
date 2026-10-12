<?php

namespace Database\Factories;

use App\Models\Laptop;
use App\Models\LaptopCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<LaptopCondition> */
class LaptopConditionFactory extends Factory
{
    protected $model = LaptopCondition::class;

    public function definition(): array
    {
        return [
            'laptop_id' => Laptop::factory(),
            'battery_health' => fake()->numberBetween(60, 100).'%',
            'screen_condition' => fake()->randomElement(['Mulus', 'Ada goresan halus', 'Ada bayangan tipis']),
            'keyboard_status' => fake()->randomElement(['Normal', 'Satu tombol agak keras']),
            'minus_note' => null,
        ];
    }
}
