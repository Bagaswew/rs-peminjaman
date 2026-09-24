<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveBorrowingRequest;
use App\Models\Asset;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminBorrowingController extends Controller
{
    public function index(): View
    {
        $borrowings = Borrowing::with(['user', 'originBuilding', 'targetBuilding', 'asset', 'assets'])
            ->latest()->get();
        $availableAssets = Asset::query()->where('status', Asset::STATUS_AVAILABLE)->get()->groupBy('name');

        return view('admin.borrowings.index', compact('borrowings', 'availableAssets'));
    }

    public function approve(ApproveBorrowingRequest $request, Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('approve', $borrowing);

        DB::transaction(function () use ($request, $borrowing): void {
            $lockedBorrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            if ($lockedBorrowing->status !== Borrowing::STATUS_PENDING) {
                throw ValidationException::withMessages(['asset_id' => 'Pengajuan sudah diproses.']);
            }

            $assetIds = $request->validated('asset_id')
                ? [$request->validated('asset_id')]
                : Asset::query()
                    ->where('building_id', $lockedBorrowing->origin_building_id)
                    ->where('name', $lockedBorrowing->item_type)
                    ->where('status', Asset::STATUS_AVAILABLE)
                    ->lockForUpdate()
                    ->limit($lockedBorrowing->quantity)
                    ->pluck('id')
                    ->all();

            if (count($assetIds) < $lockedBorrowing->quantity) {
                throw ValidationException::withMessages(['asset_id' => 'Unit tersedia tidak mencukupi untuk jumlah yang diajukan.']);
            }

            $assets = Asset::query()->lockForUpdate()->whereIn('id', $assetIds)->get();

            if ($assets->count() !== $lockedBorrowing->quantity || $assets->contains(fn(Asset $asset): bool => $asset->status !== Asset::STATUS_AVAILABLE || $asset->name !== $lockedBorrowing->item_type)) {
                throw ValidationException::withMessages(['asset_id' => 'Unit tidak tersedia atau jenis aset tidak sesuai.']);
            }

            $assets->each(fn(Asset $asset): bool => $asset->update(['status' => Asset::STATUS_BORROWED]));
            $lockedBorrowing->update([
                'asset_id' => $assets->first()->id,
                'status' => Borrowing::STATUS_APPROVED,
            ]);
            $lockedBorrowing->assets()->sync($assets->pluck('id'));
        });

        return to_route('admin.borrowings.index')->with('status', 'Pengajuan disetujui dan unit dialokasikan.');
    }

    public function reject(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('reject', $borrowing);
        $borrowing->update(['status' => Borrowing::STATUS_REJECTED]);

        return to_route('admin.borrowings.index')->with('status', 'Pengajuan ditolak.');
    }

    public function return(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('returnBorrowing', $borrowing);

        $request->validate([
            'asset_status' => ['required', 'in:' . Asset::STATUS_AVAILABLE],
        ]);

        DB::transaction(function () use ($request, $borrowing): void {
            $lockedBorrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            $assetIds = $lockedBorrowing->assets()->pluck('assets.id');
            if ($assetIds->isEmpty() && $lockedBorrowing->asset_id !== null) {
                $assetIds = collect([$lockedBorrowing->asset_id]);
            }
            Asset::query()->whereIn('id', $assetIds)->lockForUpdate()->get()
                ->each(fn(Asset $asset): bool => $asset->update(['status' => $request->asset_status]));

            $lockedBorrowing->update([
                'status' => Borrowing::STATUS_RETURNED,
                'return_date' => today(),
            ]);
        });

        return to_route('admin.borrowings.index')->with('status', 'Pengembalian berhasil diverifikasi.');
    }
}
