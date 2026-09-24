<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-800 border border-slate-700 px-3 py-1 text-xs font-semibold text-sky-400">
                    <span class="flex h-2 w-2 rounded-full bg-sky-500 shadow-[0_0_8px_rgba(14,165,233,0.8)]"></span>
                    Pusat Kendali IT
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 drop-shadow-sm">
                    Antrean Pengajuan
                </h2>
                <p class="text-sm text-slate-500 font-medium">Tinjau, alokasikan unit fisik, dan kelola pengembalian aset antar-gedung.</p>
            </div>
            
            <div class="flex items-center gap-2 rounded-xl bg-white px-4 py-2 shadow-sm ring-1 ring-slate-200">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Tiket</p>
                    <p class="text-lg font-black leading-none text-slate-900">{{ $borrowings->count() }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
            <div x-data="{ show: true }" x-show="show" class="relative rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('status') }}</p>
                    <button @click="show = false" class="absolute right-4 top-4 text-emerald-500 hover:text-emerald-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="relative rounded-xl border border-rose-200 bg-rose-50 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-rose-800">{{ $errors->first() }}</p>
                    <button @click="show = false" class="absolute right-4 top-4 text-rose-500 hover:text-rose-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            @endif

            <div class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                        <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="px-6 py-5">Pemohon</th>
                                <th class="px-6 py-5">Barang & Rute</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5">Informasi Aset</th>
                                <th class="px-6 py-5 text-right">Aksi & Kendali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($borrowings as $borrowing)
                                <tr class="transition-colors hover:bg-slate-50/80 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white font-bold">
                                                {{ strtoupper(substr($borrowing->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $borrowing->user->name }}</p>
                                                <p class="text-xs font-medium text-slate-500">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-800">{{ $borrowing->item_type }}</p>
                                        <div class="mt-1 flex items-center gap-1.5">
                                            <span class="inline-flex items-center rounded-md bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold text-slate-600">{{ $borrowing->originBuilding->code }}</span>
                                            <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            <span class="inline-flex items-center rounded-md bg-sky-50 px-1.5 py-0.5 text-[10px] font-bold text-sky-700">{{ $borrowing->targetBuilding->code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = match ($borrowing->status) {
                                                'PENDING' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Menunggu Approval'],
                                                'APPROVED' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Menunggu Pengambilan'],
                                                'BORROWED' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'Barang Sedang Dipinjam'],
                                                'REJECTED' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Ditolak'],
                                                'RETURNED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => 'Selesai'],
                                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => $borrowing->status]
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 rounded-full {{ $statusConfig['bg'] }} px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider {{ $statusConfig['text'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($borrowing->asset)
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex w-fit items-center gap-1 rounded-md border border-slate-200 bg-white px-2 py-1 font-mono text-xs font-medium text-slate-600 shadow-sm">
                                                <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                {{ $borrowing->asset->serial_number }}
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-[11px] font-medium italic text-slate-400">Belum ada unit dialokasikan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($borrowing->status === 'PENDING')
                                            <div x-data="{ approvalOpen: false }" class="flex items-center justify-end gap-2">
                                                <button @click="approvalOpen = true" type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-bold text-white shadow-sm transition-all hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Tinjau
                                                </button>
                                                <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                    @csrf @method('PATCH')
                                                    <button class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-bold text-rose-600 shadow-sm ring-1 ring-inset ring-slate-200 transition-all hover:bg-rose-50 hover:text-rose-700">
                                                        Tolak
                                                    </button>
                                                </form>

                                                <!-- Approval Modal -->
                                                <div x-show="approvalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0" @keydown.escape.window="approvalOpen = false">
                                                    <div x-show="approvalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
                                                    <div x-show="approvalOpen" x-transition.scale.origin.bottom @click.outside="approvalOpen = false" class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10">
                                                        <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-4">
                                                            <div class="flex items-center justify-between">
                                                                <h3 class="text-lg font-black text-slate-900">Alokasi Unit Fisik</h3>
                                                                <button @click="approvalOpen = false" type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-500">
                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-6 text-left">
                                                            <div class="mb-5 grid grid-cols-2 gap-4 rounded-xl bg-slate-50 p-4">
                                                                <div>
                                                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pemohon</p>
                                                                    <p class="mt-1 font-semibold text-slate-800">{{ $borrowing->user->name }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Barang</p>
                                                                    <p class="mt-1 font-semibold text-slate-800">{{ $borrowing->item_type }} ({{ $borrowing->quantity }} unit)</p>
                                                                </div>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}" class="space-y-4">
                                                                @csrf @method('PATCH')
                                                                <div class="rounded-xl border border-sky-100 bg-sky-50 p-4">
                                                                    <p class="text-sm font-semibold text-sky-900">{{ $borrowing->quantity }} unit akan dialokasikan otomatis.</p>
                                                                    <p class="mt-1 text-xs text-sky-700">Sistem memilih unit {{ $borrowing->item_type }} yang tersedia di {{ $borrowing->originBuilding->name }}.</p>
                                                                    @if($availableAssets->get($borrowing->item_type, collect())->count() < $borrowing->quantity)
                                                                    <p class="mt-2 text-xs font-bold text-rose-600">Stok tersedia tidak mencukupi.</p>
                                                                    @endif
                                                                </div>
                                                                <div class="mt-6 flex justify-end gap-3 pt-2">
                                                                    <button @click="approvalOpen = false" type="button" class="rounded-lg px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Batal</button>
                                                                    <button type="submit" class="rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-slate-800 transition-colors">Approve & Alokasikan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($borrowing->status === 'BORROWED')
                                            <div x-data="{ returnOpen: false }" class="flex justify-end">
                                                <button @click="returnOpen = true" type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-bold text-white shadow-sm transition-all hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Proses Pengembalian
                                                </button>

                                                <!-- Return Modal -->
                                                <div x-show="returnOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0" @keydown.escape.window="returnOpen = false">
                                                    <div x-show="returnOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
                                                    <div x-show="returnOpen" x-transition.scale.origin.bottom @click.outside="returnOpen = false" class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10">
                                                        <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-4">
                                                            <div class="flex items-center justify-between">
                                                                <h3 class="text-lg font-black text-slate-900">Verifikasi Pengembalian</h3>
                                                                <button @click="returnOpen = false" type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-500">
                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-6 text-left">
                                                            <div class="mb-5 rounded-xl border border-indigo-100 bg-indigo-50/50 p-4">
                                                                <p class="text-sm font-semibold text-indigo-900">Mohon periksa fisik aset.</p>
                                                                <p class="mt-1 text-xs text-indigo-700">Tentukan status fisik aset saat dikembalikan oleh <strong>{{ $borrowing->user->name }}</strong>.</p>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="space-y-4">
                                                                @csrf @method('PATCH')
                                                                <div>
                                                                    <label for="asset_status_{{ $borrowing->id }}" class="block text-sm font-bold text-slate-700">Status Setelah Pengembalian</label>
                                                                    <select id="asset_status_{{ $borrowing->id }}" name="asset_status" required class="mt-2 block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                                                        <option value="AVAILABLE">Tersedia untuk dipinjam kembali (AVAILABLE)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mt-6 flex justify-end gap-3 pt-2">
                                                                    <button @click="returnOpen = false" type="button" class="rounded-lg px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Batal</button>
                                                                    <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-indigo-700 transition-colors">Verifikasi Selesai</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs font-semibold text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="mx-auto flex max-w-sm flex-col items-center justify-center text-slate-400">
                                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                                                <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600">Antrean kosong</p>
                                            <p class="mt-1 text-xs text-slate-500">Belum ada pengajuan peminjaman dari gedung lain saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>