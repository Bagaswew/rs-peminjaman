<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'origin_building_id' => Building::factory(),
            'target_building_id' => Building::factory(),
            'item_type' => 'Keyboard',
            'notes' => null,
            'borrow_date' => today(),
            'return_date' => null,
            'status' => Borrowing::STATUS_PENDING,
        ];
    }
}
