<?php

namespace Feature;

use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeader('X-API-TOKEN', config('app.api_token'));
    }

    public function testListByGeo(): void
    {
        Building::factory()->create([
            'lat' => 55.794012,
            'lon' => 49.171295,
        ]);

        $query = [
            'filter' => [
                'geo' => [
                    'lat' => 55.797741,
                    'lon' => 49.110034,
                    'radius' => 5,
                ],
            ],
        ];

        $this->get('/api/buildings/?'.http_build_query($query))
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

        $this->get('/api/buildings/?'.http_build_query($query))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    }
}
