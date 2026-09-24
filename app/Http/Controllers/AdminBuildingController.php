<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminBuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.buildings.index', ['buildings' => Building::withCount(['assets', 'users'])->orderBy('name')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        Building::create($request->validated());

        return to_route('admin.buildings.index')->with('status', 'Gedung berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Building $building): View
    {
        return view('admin.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse
    {
        $building->update($request->validated());

        return to_route('admin.buildings.index')->with('status', 'Gedung berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building): RedirectResponse
    {
        if ($building->assets()->exists() || $building->users()->exists() || $building->originBorrowings()->exists() || $building->targetBorrowings()->exists()) {
            return to_route('admin.buildings.index')->with('error', 'Gedung tidak dapat dihapus karena masih digunakan.');
        }

        $building->delete();

        return to_route('admin.buildings.index')->with('status', 'Gedung berhasil dihapus.');
    }
}
