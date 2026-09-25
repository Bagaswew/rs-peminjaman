<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Borrowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Mengembalikan stok barang dari database, dikelompokkan per nama aset.
     */
    public function stok(): JsonResponse
    {
        $grouped = Asset::with('building')
            ->get()
            ->groupBy('name')
            ->map(function ($assets, $name) {
                $available = $assets->where('status', Asset::STATUS_AVAILABLE);
                $borrowed = $assets->where('status', Asset::STATUS_BORROWED);

                /** @var array<string, int> $byBuilding */
                $byBuilding = $available
                    ->groupBy(fn (Asset $a) => $a->building?->name ?? 'Tidak Diketahui')
                    ->map(fn ($g) => $g->count())
                    ->toArray();

                return [
                    'nama' => $name,
                    'total' => $assets->count(),
                    'tersedia' => $available->count(),
                    'dipinjam' => $borrowed->count(),
                    'per_gedung' => $byBuilding,
                ];
            })
            ->values();

        return response()->json($grouped);
    }

    /**
     * Mengembalikan status peminjaman milik user yang sedang login.
     */
    public function statusPengajuan(Request $request): JsonResponse
    {
        $borrowings = Borrowing::with(['originBuilding', 'targetBuilding', 'assets'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Borrowing $b) => [
                'id' => $b->id,
                'status' => $b->status,
                'borrow_date' => $b->borrow_date?->format('d/m/Y'),
                'return_date' => $b->return_date?->format('d/m/Y'),
                'asal' => $b->originBuilding?->name,
                'tujuan' => $b->targetBuilding?->name,
                'barang' => $b->assets->pluck('name')->join(', '),
            ]);

        return response()->json($borrowings);
    }
}
