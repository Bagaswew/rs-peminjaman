<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Asset;
use App\Models\Borrowing;
use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $borrowings = $request->user()->borrowings()->with(['originBuilding', 'targetBuilding', 'asset'])
            ->latest()->get();

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Borrowing::class);
        $buildings = Building::query()->orderBy('name')->get();
        $targetBuilding = $request->user()->building;

        return view('borrowings.create', compact('buildings', 'targetBuilding'));
    }

    public function getAssetsByBuilding(int $buildingId): JsonResponse
    {
        $assets = Asset::query()
            ->where('building_id', $buildingId)
            ->where('status', Asset::STATUS_AVAILABLE)
            ->selectRaw('name, COUNT(*) as available_count')
            ->groupBy('name')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $assets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowingRequest $request): RedirectResponse
    {
        $this->authorize('create', Borrowing::class);

        $request->user()->borrowings()->create([
            ...$request->validated(),
            'status' => Borrowing::STATUS_PENDING,
        ]);

        return to_route('borrowings.index')->with('status', 'Pengajuan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing): View
    {
        $this->authorize('view', $borrowing);

        return view('borrowings.show', compact('borrowing'));
    }

    public function receive(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('receive', $borrowing);

        $borrowing->update(['status' => Borrowing::STATUS_BORROWED]);

        return back()->with('status', 'Barang telah diterima.');
    }

    public function requestReturn(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('requestReturn', $borrowing);

        $borrowing->update(['status' => Borrowing::STATUS_PENDING_RETURN]);

        return back()->with('status', 'Pengajuan pengembalian berhasil. Silakan serahkan barang ke IT Support.');
    }
}
