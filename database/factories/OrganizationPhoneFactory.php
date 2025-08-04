<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrganizationPhone>
 */
class OrganizationPhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => $this->faker->e164PhoneNumber(),
        ];
    }

    public function hasOrganization(Organization $organization): self
    {
        return $this->afterMaking(function (OrganizationPhone $phone) use ($organization) {
            $phone->organization()->associate($organization);
        });
    }
}
