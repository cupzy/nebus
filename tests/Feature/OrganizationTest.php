<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Operation;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeader('X-API-TOKEN', config('app.api_token'));
    }

    public function testListByBuilding(): void
    {
        $organization = Organization::factory()->create();

        $query = [
            'filter' => [
                'building_id' => $organization->building_id,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(1, 'data');

        $query = [
            'filter' => [
                'building_id' => $organization->building_id + 1,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }

    public function testListByOperation(): void
    {
        $operation = Operation::factory()->create();
        Organization::factory()->hasOperations([$operation])->create();

        $query = [
            'filter' => [
                'operation_id' => $operation->id,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(1, 'data');

        $query = [
            'filter' => [
                'operation_id' => $operation->id + 1,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }

    public function testDetail(): void
    {
        $organization = Organization::factory()->create();

        $this->get('/api/organizations/'.$organization->id)
            ->assertSuccessful()
            ->assertJson([
                'id' => $organization->id,
                'name' => $organization->name,
            ]);
    }

    public function testListByName(): void
    {
        Organization::factory()->create([
            'name' => 'Multi Part Name',
        ]);

        $query = [
            'filter' => [
                'name' => 'multi part',
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(1, 'data');

        $query = [
            'filter' => [
                'name' => 'wrong',
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }

    public function testListByGeo(): void
    {
        $building = Building::factory()->create([
            'lat' => 55.794012,
            'lon' => 49.171295,
        ]);

        Organization::factory()->hasBuilding($building)->create();

        $query = [
            'filter' => [
                'geo' => [
                    'lat' => 55.797741,
                    'lon' => 49.110034,
                    'radius' => 5,
                ],
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(1, 'data');

        $query = [
            'filter' => [
                'geo' => [
                    'lat' => 55.797741,
                    'lon' => 49.110034,
                    'radius' => 2,
                ],
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }

    public function testListByParentOperation(): void
    {
        $emptyOperation = Operation::factory()->create();
        $parentOperation = Operation::factory()->create();
        $operation = Operation::factory()->hasParent($parentOperation)->create();
        Organization::factory()->hasOperations([$operation])->create();

        $query = [
            'filter' => [
                'parent_operation_id' => $parentOperation->id,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(1, 'data');

        $query = [
            'filter' => [
                'parent_operation_id' => $emptyOperation->id,
            ],
        ];

        $this->get('/api/organizations/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }
}
