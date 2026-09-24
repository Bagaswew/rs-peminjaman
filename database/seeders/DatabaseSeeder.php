<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $buildings = collect([
            ['code' => 'MWR', 'name' => 'Gedung Mawar'],
            ['code' => 'SJD', 'name' => 'Gedung Sujudi'],
            ['code' => 'AFT', 'name' => 'Gedung Afiat'],
            ['code' => 'EBN', 'name' => 'Gedung Ebony'],
            ['code' => 'GDN', 'name' => 'Gedung Garden'],
            ['code' => 'FLM', 'name' => 'Gedung Flamboyan'],
            ['code' => 'UPF', 'name' => 'Unit Pelayanan Farmasi'],
            ['code' => 'LOG', 'name' => 'Logistik'],
        ])->mapWithKeys(fn (array $building): array => [
            $building['code'] => Building::create($building),
        ]);

        User::factory()->create([
            'name' => 'IT Support',
            'email' => 'support@example.com',
            'role' => User::ROLE_IT_SUPPORT,
            'building_id' => null,
        ]);

        User::factory()->create([
            'name' => 'Petugas Mawar',
            'email' => 'petugas.mawar@example.com',
            'building_id' => $buildings['MWR']->id,
        ]);

        Asset::factory()->createMany([
            ['name' => 'Keyboard', 'building_id' => $buildings['LOG']->id],
            ['name' => 'Mouse', 'building_id' => $buildings['LOG']->id],
            ['name' => 'Monitor', 'building_id' => $buildings['LOG']->id],
        ]);
    }
}
