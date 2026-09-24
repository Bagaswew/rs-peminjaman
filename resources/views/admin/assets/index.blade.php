<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-indigo-50 border border-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-600">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    Manajemen Inventaris
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Daftar Aset</h2>
                <p class="text-sm text-slate-500">Kelola seluruh perangkat IT yang terdaftar dalam sistem.</p>
            </div>
            <a href="{{ route('admin.assets.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Aset
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">
        @if (session('status'))
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <section
            class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.05)] ring-1 ring-slate-100">
            <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-5">
                <h3 class="text-base font-bold text-slate-900">Ringkasan Ketersediaan Unit</h3>
                <p class="mt-1 text-xs font-medium text-slate-500">Jumlah unit dihitung otomatis berdasarkan status aset
                    saat ini.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                    <thead class="bg-slate-50/50 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Jenis Barang</th>
                            <th class="px-6 py-4">Gedung</th>
                            <th class="px-6 py-4 text-center">Total Unit</th>
                            <th class="px-6 py-4 text-center">Tersedia</th>
                            <th class="px-6 py-4 text-center">Dipinjam</th>
                            <th class="px-6 py-4 text-right">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($assetSummaries as $summary)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $summary['name'] }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-bold text-indigo-700">{{ $summary['building']->code }}</span>
                                    <span class="ml-1 text-xs text-slate-500">{{ $summary['building']->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-700">{{ $summary['total'] }}</td>
                                <td class="px-6 py-4 text-center font-bold text-emerald-600">{{ $summary['available'] }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-indigo-600">{{ $summary['borrowed'] }}</td>
                                <td class="px-6 py-4 text-right">
                                    <details class="relative inline-block text-left">
                                        <summary
                                            class="cursor-pointer list-none rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50">
                                            Lihat unit
                                        </summary>
                                        <div
                                            class="absolute right-0 z-10 mt-2 w-96 max-w-[calc(100vw-3rem)] overflow-hidden rounded-xl border border-slate-200 bg-white p-2 text-left shadow-xl">
                                            @foreach ($summary['assets'] as $asset)
                                                <div
                                                    class="flex items-center justify-between gap-3 rounded-lg px-3 py-2 hover:bg-slate-50">
                                                    <div class="min-w-0">
                                                        <p class="truncate font-mono text-xs font-bold text-slate-700">
                                                            {{ $asset->asset_code }}</p>
                                                        <p class="truncate font-mono text-[11px] text-slate-400">
                                                            {{ $asset->serial_number }}</p>
                                                    </div>
                                                    <div class="flex shrink-0 items-center gap-2">
                                                        <span
                                                            class="text-[11px] font-bold {{ $asset->status === 'AVAILABLE' ? 'text-emerald-600' : 'text-indigo-600' }}">
                                                            {{ $asset->status === 'AVAILABLE' ? 'Tersedia' : 'Dipinjam' }}
                                                        </span>
                                                        <a href="{{ route('admin.assets.edit', $asset) }}"
                                                            class="text-xs font-bold text-slate-500 hover:text-indigo-600">Edit</a>
                                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}"
                                                            onsubmit="return confirm('Hapus aset {{ $asset->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                            @csrf @method('DELETE')
                                                            <button
                                                                class="text-xs font-bold text-rose-500 hover:text-rose-700">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm font-medium text-slate-400">Belum ada
                                    data unit aset.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section
            class="hidden overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.05)] ring-1 ring-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                    <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Kode Aset</th>
                            <th class="px-6 py-4">Jenis & Serial</th>
                            <th class="px-6 py-4">Gedung</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($assets as $asset)
                            <tr class="group transition-colors hover:bg-slate-50/80">
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-xs font-bold text-slate-600 group-hover:bg-slate-200 transition-colors">
                                        {{ $asset->asset_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $asset->name }}</p>
                                    <span class="font-mono text-xs text-slate-400">{{ $asset->serial_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="inline-flex rounded-md bg-indigo-50 px-2 py-0.5 text-[11px] font-bold text-indigo-700">{{ $asset->building->code }}</span>
                                        <span class="text-slate-600 text-xs">{{ $asset->building->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $sc = match ($asset->status) {
                                            'AVAILABLE' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Tersedia'],
                                            'BORROWED' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'Dipinjam'],
                                            default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400', 'label' => $asset->status],
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full {{ $sc['bg'] }} px-2.5 py-1 text-xs font-bold {{ $sc['text'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.assets.edit', $asset) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}"
                                            onsubmit="return confirm('Hapus aset {{ $asset->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-100 transition-colors">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="h-12 w-12 text-slate-200" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-sm font-medium">Belum ada aset terdaftar</p>
                                        <a href="{{ route('admin.assets.create') }}"
                                            class="text-xs font-bold text-indigo-600 hover:text-indigo-700">+ Tambah aset
                                            pertama</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>