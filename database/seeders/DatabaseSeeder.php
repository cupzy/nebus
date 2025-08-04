<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Operation;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $foodOperation = Operation::factory()->create(['name' => 'Еда']);
        $carOperation = Operation::factory()->create(['name' => 'Автомобили']);
        Operation::query()->insert([
            ['parent_id' => $foodOperation->id, 'name' => 'Мясная продукция'],
            ['parent_id' => $foodOperation->id, 'name' => 'Молочная продукция'],
            ['parent_id' => $carOperation->id, 'name' => 'Грузовые'],
            ['parent_id' => $carOperation->id, 'name' => 'Легковые'],
            ['parent_id' => $carOperation->id, 'name' => 'Запчасти'],
            ['parent_id' => $carOperation->id, 'name' => 'Аксессуары'],
        ]);
        $operations = Operation::query()->get();
        /** @var Collection $buildings */
        $buildings = Building::factory(10)->create();
        foreach ($buildings as $building) {
            Organization::factory(rand(0, 10))->hasRandomPhone()->hasBuilding($building)->hasOperations([$operations->get(rand(0, 7))])->create();
        }
    }
}
