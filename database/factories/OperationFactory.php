<?php

namespace Database\Factories;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Operation>
 */
class OperationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'parent_id' => null,
        ];
    }

    public function hasParent(Operation $parent): self
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parent->id,
        ]);
    }
}
