<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $assets = Asset::with('building')->latest()->get();
        $assetSummaries = $assets
            ->groupBy(fn(Asset $asset): string => $asset->building->id . '-' . $asset->name)
            ->map(function ($group): array {
                $asset = $group->first();

                return [
                    'name' => $asset->name,
                    'building' => $asset->building,
                    'assets' => $group->values(),
                    'total' => $group->count(),
                    'available' => $group->where('status', Asset::STATUS_AVAILABLE)->count(),
                    'borrowed' => $group->where('status', Asset::STATUS_BORROWED)->count(),
                ];
            })
            ->sortBy(fn(array $summary): string => $summary['building']->name . '-' . $summary['name'])
            ->values();

        return view('admin.assets.index', compact('assets', 'assetSummaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.assets.create', ['buildings' => Building::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $quantity = $validated['quantity'] ?? 1;
        $assetCodes = collect(range(1, $quantity))->map(fn(int $number): string => $this->unitIdentifier($validated['asset_code'], $number, $quantity));
        $serialNumbers = collect(range(1, $quantity))->map(fn(int $number): string => $this->unitIdentifier($validated['serial_number'], $number, $quantity));

        if (Asset::query()->whereIn('asset_code', $assetCodes)->orWhereIn('serial_number', $serialNumbers)->exists()) {
            throw ValidationException::withMessages([
                'asset_code' => 'Kode atau serial unit hasil otomatis sudah digunakan. Gunakan kode awal yang berbeda.',
            ]);
        }

        DB::transaction(function () use ($validated, $quantity): void {
            foreach (range(1, $quantity) as $number) {
                Asset::create([
                    'asset_code' => $this->unitIdentifier($validated['asset_code'], $number, $quantity),
                    'name' => $validated['name'],
                    'serial_number' => $this->unitIdentifier($validated['serial_number'], $number, $quantity),
                    'building_id' => $validated['building_id'],
                    'status' => Asset::STATUS_AVAILABLE,
                ]);
            }
        });

        return to_route('admin.assets.index')->with('status', $quantity === 1
            ? 'Aset berhasil ditambahkan.'
            : $quantity . ' unit aset berhasil ditambahkan.');
    }

    private function unitIdentifier(string $value, int $number, int $quantity): string
    {
        return $quantity === 1 ? $value : $value . '-' . str_pad((string) $number, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified resource.
     */
    public function edit(Asset $asset): View
    {
        return view('admin.assets.edit', [
            'asset' => $asset,
            'buildings' => Building::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $asset->update([
            ...$request->validated(),
            'status' => $asset->status ?? Asset::STATUS_AVAILABLE,
        ]);

        return to_route('admin.assets.index')->with('status', 'Aset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset): RedirectResponse
    {
        if ($asset->borrowings()->exists()) {
            return to_route('admin.assets.index')->with('error', 'Aset tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $asset->delete();

        return to_route('admin.assets.index')->with('status', 'Aset berhasil dihapus.');
    }
}
