<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'building_id' => Building::factory(),
        ];
    }

    public function hasOperations(iterable $operations): self
    {
        return $this->afterCreating(function (Organization $organization) use ($operations) {
            $organization->operations()->sync($operations);
        });
    }

    public function hasBuilding(Building $building): self
    {
        return $this->state(fn () => [
            'building_id' => $building->id,
        ]);
    }

    public function hasRandomPhone(): self
    {
        return $this->afterCreating(function (Organization $organization) {
            OrganizationPhone::factory()->hasOrganization($organization)->create();
        });
    }
}
