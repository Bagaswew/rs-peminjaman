<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Building;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetBuildingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_support_can_create_and_update_a_building(): void
    {
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);

        $create = $this->actingAs($support)->post(route('admin.buildings.store'), [
            'code' => 'MWR',
            'name' => 'Gedung Mawar',
        ]);

        $building = Building::query()->where('code', 'MWR')->firstOrFail();
        $create->assertRedirect(route('admin.buildings.index'));

        $update = $this->actingAs($support)->put(route('admin.buildings.update', $building), [
            'code' => 'MWR',
            'name' => 'Gedung Mawar Utama',
        ]);

        $update->assertRedirect(route('admin.buildings.index'));
        $this->assertDatabaseHas('buildings', ['id' => $building->id, 'name' => 'Gedung Mawar Utama']);
    }

    public function test_it_support_can_create_and_update_an_asset(): void
    {
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $building = Building::factory()->create();

        $create = $this->actingAs($support)->post(route('admin.assets.store'), [
            'asset_code' => 'AST-001',
            'name' => 'Keyboard',
            'serial_number' => 'SN-001',
            'building_id' => $building->id,
        ]);

        $asset = Asset::query()->where('asset_code', 'AST-001')->firstOrFail();
        $create->assertRedirect(route('admin.assets.index'));
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'status' => Asset::STATUS_AVAILABLE]);

        $update = $this->actingAs($support)->put(route('admin.assets.update', $asset), [
            'asset_code' => 'AST-001',
            'name' => 'Keyboard Wireless',
            'serial_number' => 'SN-001',
            'building_id' => $building->id,
        ]);

        $update->assertRedirect(route('admin.assets.index'));
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'name' => 'Keyboard Wireless', 'status' => Asset::STATUS_AVAILABLE]);
    }

    public function test_building_user_cannot_manage_assets_or_buildings(): void
    {
        $user = User::factory()->create();

        $buildingResponse = $this->actingAs($user)->get(route('admin.buildings.index'));
        $assetResponse = $this->actingAs($user)->get(route('admin.assets.index'));

        $buildingResponse->assertForbidden();
        $assetResponse->assertForbidden();
    }

    public function test_it_support_can_create_multiple_asset_units(): void
    {
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $building = Building::factory()->create();

        $response = $this->actingAs($support)->post(route('admin.assets.store'), [
            'asset_code' => 'AST-100',
            'name' => 'Laptop',
            'serial_number' => 'SN-100',
            'quantity' => 3,
            'building_id' => $building->id,
        ]);

        $response->assertRedirect(route('admin.assets.index'));
        $this->assertDatabaseCount('assets', 3);
        $this->assertDatabaseHas('assets', ['asset_code' => 'AST-100-01', 'serial_number' => 'SN-100-01']);
        $this->assertDatabaseHas('assets', ['asset_code' => 'AST-100-03', 'serial_number' => 'SN-100-03']);
    }

    public function test_duplicate_asset_identifiers_are_rejected(): void
    {
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $building = Building::factory()->create();
        Asset::factory()->create([
            'asset_code' => 'AST-001',
            'serial_number' => 'SN-001',
            'building_id' => $building->id,
        ]);

        $response = $this->actingAs($support)->post(route('admin.assets.store'), [
            'asset_code' => 'AST-001',
            'name' => 'Mouse',
            'serial_number' => 'SN-001',
            'building_id' => $building->id,
        ]);

        $response->assertSessionHasErrors(['asset_code', 'serial_number']);
    }

    public function test_building_with_related_records_cannot_be_deleted(): void
    {
        $support = User::factory()->create(['role' => User::ROLE_IT_SUPPORT, 'building_id' => null]);
        $building = Building::factory()->create();
        Asset::factory()->create(['building_id' => $building->id]);

        $response = $this->actingAs($support)->delete(route('admin.buildings.destroy', $building));

        $response->assertRedirect(route('admin.buildings.index'));
        $response->assertSessionHas('error');
        $this->assertModelExists($building);
    }
}
