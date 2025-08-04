<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Building>
 */
class BuildingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
        ];
    }
}
