<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-sky-50 border border-sky-100 px-3 py-1 text-xs font-semibold text-sky-600">
                    <span class="flex h-2 w-2 rounded-full bg-sky-500 shadow-[0_0_8px_rgba(14,165,233,0.8)]"></span>
                    Ruang Kerja Saya
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 drop-shadow-sm">
                    Pengajuan Saya
                </h2>
                <p class="text-sm text-slate-500 font-medium">Pantau status permintaan aset dan konfirmasi penerimaan
                    barang.</p>
            </div>

            <div class="relative group">
                <div
                    class="absolute -inset-0.5 rounded-lg bg-gradient-to-r from-sky-500 to-indigo-500 opacity-30 blur group-hover:opacity-50 transition duration-300">
                </div>
                <a href="{{ route('borrowings.create') }}"
                    class="relative inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-slate-800 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="h-5 w-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pengajuan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show"
                    class="relative rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('status') }}</p>
                        <button @click="show = false"
                            class="absolute right-4 top-4 text-emerald-500 hover:text-emerald-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div
                class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                        <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="px-6 py-5">Info Barang</th>
                                <th class="px-6 py-5">Tujuan</th>
                                <th class="px-6 py-5">Tanggal</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($borrowings as $borrowing)
                                <tr class="transition-colors hover:bg-slate-50/80 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500 group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $borrowing->item_type }}</p>
                                                @if($borrowing->asset)
                                                    <p
                                                        class="mt-0.5 inline-flex items-center gap-1 rounded-md border border-slate-200 bg-white px-1.5 py-0.5 font-mono text-[10px] font-semibold text-slate-500">
                                                        SN: {{ $borrowing->asset->serial_number }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            <span
                                                class="font-semibold text-slate-700">{{ $borrowing->targetBuilding->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-medium text-slate-700">{{ $borrowing->borrow_date->format('d M Y') }}</span>
                                            @if ($borrowing->status === 'BORROWED' && $borrowing->return_date)
                                                <span
                                                    class="mt-1 flex items-center gap-1 text-[11px] font-semibold text-rose-500">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Tenggat: {{ $borrowing->return_date->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = match ($borrowing->status) {
                                                'PENDING' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Menunggu Persetujuan'],
                                                'APPROVED' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Disetujui'],
                                                'BORROWED' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'Sedang Dipinjam'],
                                                'REJECTED' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Ditolak'],
                                                'RETURNED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => 'Selesai'],
                                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => $borrowing->status]
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full {{ $statusConfig['bg'] }} px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider {{ $statusConfig['text'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($borrowing->status === 'APPROVED')
                                            <form method="POST" action="{{ route('borrowings.receive', $borrowing) }}"
                                                class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin sudah menerima barang ini fisiknya?')"
                                                    class="group relative inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-xs font-bold text-white shadow-sm transition-all hover:bg-emerald-600 hover:shadow focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Terima Barang
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex max-w-sm flex-col items-center justify-center text-slate-400">
                                            <div
                                                class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                                                <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600">Belum ada pengajuan</p>
                                            <p class="mt-1 text-xs text-slate-500">Anda belum pernah mengajukan peminjaman
                                                aset. Klik tombol "Buat Pengajuan Baru" di atas untuk memulai.</p>
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