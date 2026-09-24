<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Borrowing;
use App\Models\Building;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_pending_borrowing(): void
    {
        $userBuilding = Building::factory()->create();
        $origin = Building::factory()->create();
        $asset = Asset::factory()->create([
            'building_id' => $origin->id,
            'name' => 'Keyboard',
            'status' => Asset::STATUS_AVAILABLE,
        ]);
        $user = User::factory()->create(['building_id' => $userBuilding->id]);

        $response = $this->actingAs($user)->post(route('borrowings.store'), [
            'origin_building_id' => $origin->id,
            'target_building_id' => $userBuilding->id,
            'item_type' => 'Keyboard',
            'borrow_date' => '2026-09-24',
            'return_date' => '2026-09-26',
        ]);

        $response->assertRedirect(route('borrowings.index'));
        $this->assertDatabaseHas('borrowings', [
            'user_id' => $user->id,
            'origin_building_id' => $origin->id,
            'target_building_id' => $userBuilding->id,
            'status' => Borrowing::STATUS_PENDING,
        ]);
    }

    public function test_available_asset_types_are_returned_for_a_building(): void
    {
        $userBuilding = Building::factory()->create();
        $origin = Building::factory()->create();
        $user = User::factory()->create(['building_id' => $userBuilding->id]);
        Asset::factory()->create(['building_id' => $origin->id, 'name' => 'Keyboard', 'status' => Asset::STATUS_AVAILABLE]);
        Asset::factory()->create(['building_id' => $origin->id, 'name' => 'Keyboard', 'status' => Asset::STATUS_AVAILABLE]);
        Asset::factory()->create(['building_id' => $origin->id, 'name' => 'Mouse', 'status' => Asset::STATUS_BORROWED]);

        $response = $this->actingAs($user)->getJson(route('borrowings.assets-by-building', $origin));

        $response->assertOk()->assertJsonPath('data', [
            ['name' => 'Keyboard', 'available_count' => 2],
        ]);
    }

    public function test_request_rejects_an_item_type_unavailable_in_the_origin_building(): void
    {
        $userBuilding = Building::factory()->create();
        $origin = Building::factory()->create();
        $user = User::factory()->create(['building_id' => $userBuilding->id]);

        $response = $this->actingAs($user)->post(route('borrowings.store'), [
            'origin_building_id' => $origin->id,
            'target_building_id' => $userBuilding->id,
            'item_type' => 'Laptop',
            'borrow_date' => '2026-09-24',
            'return_date' => '2026-09-26',
        ]);

        $response->assertSessionHasErrors('item_type');
    }

    public function test_it_support_can_approve_and_verify_return(): void
    {
        $origin = Building::factory()->create();
        $target = Building::factory()->create();
        $user = User::factory()->create(['building_id' => $origin->id]);
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $asset = Asset::factory()->create(['building_id' => $origin->id, 'name' => 'Keyboard', 'status' => Asset::STATUS_AVAILABLE]);
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'origin_building_id' => $origin->id,
            'target_building_id' => $target->id,
            'item_type' => 'Keyboard',
        ]);

        $approve = $this->actingAs($support)->patch(route('admin.borrowings.approve', $borrowing), ['asset_id' => $asset->id]);

        $approve->assertRedirect(route('admin.borrowings.index'));
        $this->assertDatabaseHas('borrowings', ['id' => $borrowing->id, 'asset_id' => $asset->id, 'status' => Borrowing::STATUS_APPROVED]);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'status' => Asset::STATUS_BORROWED]);

        $return = $this->actingAs($support)->patch(route('admin.borrowings.return', $borrowing), ['asset_status' => Asset::STATUS_AVAILABLE]);

        $return->assertRedirect(route('admin.borrowings.index'));
        $this->assertDatabaseHas('borrowings', ['id' => $borrowing->id, 'status' => Borrowing::STATUS_RETURNED]);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'status' => Asset::STATUS_AVAILABLE]);
    }

    public function test_approval_rejects_an_unavailable_or_wrong_asset_without_changes(): void
    {
        $origin = Building::factory()->create();
        $target = Building::factory()->create();
        $user = User::factory()->create(['building_id' => $origin->id]);
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $asset = Asset::factory()->create(['name' => 'Mouse', 'status' => Asset::STATUS_AVAILABLE]);
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'origin_building_id' => $origin->id,
            'target_building_id' => $target->id,
            'item_type' => 'Keyboard',
        ]);

        $response = $this->actingAs($support)->patch(route('admin.borrowings.approve', $borrowing), ['asset_id' => $asset->id]);

        $response->assertSessionHasErrors('asset_id');
        $this->assertDatabaseHas('borrowings', ['id' => $borrowing->id, 'status' => Borrowing::STATUS_PENDING, 'asset_id' => null]);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'status' => Asset::STATUS_AVAILABLE]);
    }

    public function test_return_allows_only_available_status_after_borrowing_completion(): void
    {
        $origin = Building::factory()->create();
        $target = Building::factory()->create();
        $user = User::factory()->create(['building_id' => $origin->id]);
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $asset = Asset::factory()->create(['building_id' => $origin->id, 'name' => 'Keyboard', 'status' => Asset::STATUS_BORROWED]);
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'asset_id' => $asset->id,
            'origin_building_id' => $origin->id,
            'target_building_id' => $target->id,
            'item_type' => 'Keyboard',
            'status' => Borrowing::STATUS_APPROVED,
        ]);

        $response = $this->actingAs($support)->patch(route('admin.borrowings.return', $borrowing), ['asset_status' => Asset::STATUS_AVAILABLE]);

        $response->assertRedirect(route('admin.borrowings.index'));
        $this->assertDatabaseHas('borrowings', ['id' => $borrowing->id, 'status' => Borrowing::STATUS_RETURNED]);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'status' => Asset::STATUS_AVAILABLE]);
    }

    public function test_building_user_cannot_approve_a_borrowing(): void
    {
        $user = User::factory()->create();
        $borrowing = Borrowing::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patch(route('admin.borrowings.approve', $borrowing), ['asset_id' => 1]);

        $response->assertForbidden();
    }
}
