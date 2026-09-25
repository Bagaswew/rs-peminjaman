<?php

use App\Http\Controllers\AdminAssetController;
use App\Http\Controllers\AdminBorrowingController;
use App\Http\Controllers\AdminBuildingController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfileController;
use App\Models\Asset;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? to_route('dashboard') : to_route('login');
});

Route::get('/dashboard', function () {
    $user = request()->user();
    $borrowings = $user->role === 'it_support' ? Borrowing::query() : $user->borrowings();
    $baseQuery = $user->role === 'it_support'
        ? Borrowing::with(['user', 'originBuilding', 'targetBuilding', 'asset'])->latest()
        : $user->borrowings()->with(['originBuilding', 'targetBuilding', 'asset'])->latest();

    return view('dashboard', [
        'activeBorrowings' => (clone $borrowings)->whereIn('status', [
            Borrowing::STATUS_APPROVED,
            Borrowing::STATUS_BORROWED,
            Borrowing::STATUS_PENDING_RETURN,
        ])->count(),
        'pendingBorrowings' => (clone $borrowings)->where('status', Borrowing::STATUS_PENDING)->count(),
        'availableAssets' => $user->role === 'it_support' ? Asset::query()->where('status', Asset::STATUS_AVAILABLE)->get()->groupBy('name') : collect(),
        'recentBorrowings' => (clone $baseQuery)
            ->whereIn('status', [
                Borrowing::STATUS_PENDING,
                Borrowing::STATUS_APPROVED,
                Borrowing::STATUS_BORROWED,
                Borrowing::STATUS_PENDING_RETURN,
            ])
            ->take(5)
            ->get(),
        'historyBorrowings' => (clone $baseQuery)
            ->whereIn('status', [Borrowing::STATUS_RETURNED, Borrowing::STATUS_REJECTED])
            ->take(10)
            ->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('role:user_gedung')->group(function () {
        Route::get('borrowings/assets/{buildingId}', [BorrowingController::class, 'getAssetsByBuilding'])
            ->name('borrowings.assets-by-building');
        Route::patch('borrowings/{borrowing}/receive', [BorrowingController::class, 'receive'])->name('borrowings.receive');
        Route::patch('borrowings/{borrowing}/request-return', [BorrowingController::class, 'requestReturn'])->name('borrowings.request-return');
        Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::prefix('admin')->name('admin.')->middleware('role:it_support')->group(function () {
        Route::resource('buildings', AdminBuildingController::class)->except(['show']);
        Route::resource('assets', AdminAssetController::class)->except(['show']);
        Route::get('borrowings', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
        Route::patch('borrowings/{borrowing}/approve', [AdminBorrowingController::class, 'approve'])->name('borrowings.approve');
        Route::patch('borrowings/{borrowing}/reject', [AdminBorrowingController::class, 'reject'])->name('borrowings.reject');
        Route::patch('borrowings/{borrowing}/return', [AdminBorrowingController::class, 'return'])->name('borrowings.return');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chatbot API routes
    Route::get('/chatbot/stok', [ChatbotController::class, 'stok'])->name('chatbot.stok');
    Route::get('/chatbot/status-pengajuan', [ChatbotController::class, 'statusPengajuan'])->name('chatbot.status-pengajuan');
});

require __DIR__.'/auth.php';
