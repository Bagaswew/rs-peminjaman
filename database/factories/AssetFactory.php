<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_code' => fake()->unique()->bothify('AST-####'),
            'name' => fake()->randomElement(['Keyboard', 'Mouse', 'Monitor', 'Laptop']),
            'serial_number' => fake()->unique()->bothify('SN-########'),
            'building_id' => Building::factory(),
            'status' => Asset::STATUS_AVAILABLE,
        ];
    }
}
