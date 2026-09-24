<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50/50 border border-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-600 backdrop-blur-sm">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span>
                    Ringkasan Operasional
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 drop-shadow-sm">
                    Peminjaman Aset IT
                </h2>
                <p class="text-sm text-slate-500 font-medium">Pantau pergerakan aset dan kelola permintaan antar-gedung dengan mudah.</p>
            </div>
            
            <div class="relative group">
                <div class="absolute -inset-0.5 rounded-lg bg-gradient-to-r from-indigo-500 to-sky-500 opacity-20 blur group-hover:opacity-40 transition duration-300"></div>
                @if (auth()->user()->role === 'user_gedung')
                <a href="{{ route('borrowings.create') }}" class="relative inline-flex items-center justify-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-bold text-slate-900 shadow-sm ring-1 ring-slate-900/10 hover:bg-slate-50 hover:ring-slate-900/20 transition-all duration-200">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                    Buat Pengajuan Baru
                </a>
                @else
                <a href="{{ route('admin.borrowings.index') }}" class="relative inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-slate-800 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                    Kelola Antrean
                    <svg class="h-5 w-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Card 1 -->
            <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100 transition-all hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-50 opacity-50 transition-transform group-hover:scale-150"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Peminjaman Aktif</p>
                        <div class="mt-4 flex items-baseline gap-2">
                            <p class="text-4xl font-black tracking-tight text-slate-900">{{ $activeBorrowings }}</p>
                            <span class="text-sm font-medium text-slate-500">unit</span>
                        </div>
                        <p class="mt-2 text-xs font-medium text-slate-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Sedang digunakan saat ini
                        </p>
                    </div>
                    <div class="rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 p-3 text-white shadow-lg shadow-indigo-500/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16v14H4zM8 9h8M8 13h5" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100 transition-all hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-amber-100 to-amber-50 opacity-50 transition-transform group-hover:scale-150"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Menunggu Approval</p>
                        <div class="mt-4 flex items-baseline gap-2">
                            <p class="text-4xl font-black tracking-tight text-slate-900">{{ $pendingBorrowings }}</p>
                            <span class="text-sm font-medium text-slate-500">tiket</span>
                        </div>
                        <p class="mt-2 text-xs font-medium text-slate-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Perlu ditindaklanjuti segera
                        </p>
                    </div>
                    <div class="rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 p-3 text-white shadow-lg shadow-amber-500/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <section class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Aktivitas Terbaru</h3>
                        <p class="text-xs font-medium text-slate-500">Status yang sedang aktif dan butuh perhatian.</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                    <thead class="bg-slate-50/50 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Barang / Peminjam</th>
                            <th class="px-6 py-4">Rute Pengiriman</th>
                            <th class="px-6 py-4">Serial / Unit</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($recentBorrowings as $borrowing)
                        <tr class="transition-colors hover:bg-slate-50/80 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $borrowing->item_type }}</p>
                                        @if(auth()->user()->role === 'it_support')
                                        <p class="text-xs font-medium text-slate-500">{{ $borrowing->user->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-600">{{ $borrowing->originBuilding->code }}</span>
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-bold text-indigo-700">{{ $borrowing->targetBuilding->code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($borrowing->asset)
                                <span class="inline-flex items-center gap-1.5 rounded-md border border-slate-200 bg-white px-2 py-1 font-mono text-xs font-medium text-slate-600 shadow-sm">
                                    <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    {{ $borrowing->asset->serial_number }} - {{ $borrowing->asset->name }}
                                </span>
                                @else
                                <span class="text-xs font-medium italic text-slate-400">Belum dialokasikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = match ($borrowing->status) {
                                        'PENDING' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Menunggu'],
                                        'APPROVED' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Telah Disetujui'],
                                        'BORROWED' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'Sedang Dipinjam'],
                                        'PENDING_RETURN' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'dot' => 'bg-orange-500', 'label' => 'Menunggu Verifikasi'],
                                        'REJECTED' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Ditolak'],
                                        'RETURNED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => 'Selesai'],
                                        default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => $borrowing->status]
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full {{ $statusConfig['bg'] }} px-2.5 py-1 text-xs font-bold {{ $statusConfig['text'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if (auth()->user()->role === 'user_gedung')
                                    @if ($borrowing->status === 'APPROVED')
                                    <form method="POST" action="{{ route('borrowings.receive', $borrowing) }}" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin sudah menerima barang ini fisiknya?')" class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Terima Barang
                                        </button>
                                    </form>
                                    @elseif ($borrowing->status === 'BORROWED')
                                    <form method="POST" action="{{ route('borrowings.request-return', $borrowing) }}" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('Ajukan pengembalian? Anda harus membawa barang langsung ke IT Support.')" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                    @elseif ($borrowing->status === 'PENDING_RETURN')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-bold text-orange-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu IT
                                    </span>
                                    @else
                                    <span class="text-slate-300">-</span>
                                    @endif
                                @elseif (auth()->user()->role === 'it_support')
                                    @if ($borrowing->status === 'PENDING')
                                        <div x-data="{ approvalOpen: false }" class="flex items-center justify-end gap-2">
                                            <button @click="approvalOpen = true" type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Tinjau
                                            </button>
                                            <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                @csrf @method('PATCH')
                                                <button class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-rose-600 shadow-sm ring-1 ring-inset ring-slate-200 transition-all hover:bg-rose-50 hover:text-rose-700">
                                                    Tolak
                                                </button>
                                            </form>

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
                                                                <p class="mt-1 font-semibold text-slate-800">{{ $borrowing->item_type }}</p>
                                                            </div>
                                                        </div>
                                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}" class="space-y-4">
                                                            @csrf @method('PATCH')
                                                            <div>
                                                                <label for="asset_id_{{ $borrowing->id }}" class="block text-sm font-bold text-slate-700">Pilih Unit {{ $borrowing->item_type }} Tersedia</label>
                                                                <select id="asset_id_{{ $borrowing->id }}" name="asset_id" required class="mt-2 block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                                                    <option value="">-- Pilih Nomor Seri (SN) --</option>
                                                                    @foreach ($availableAssets->get($borrowing->item_type, collect()) as $asset)
                                                                        <option value="{{ $asset->id }}">{{ $asset->serial_number }} - {{ $asset->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if($availableAssets->get($borrowing->item_type, collect())->isEmpty())
                                                                <p class="mt-2 text-xs text-rose-500 font-medium">Perhatian: Tidak ada unit {{ $borrowing->item_type }} yang tersedia saat ini.</p>
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
                                    @elseif (in_array($borrowing->status, ['BORROWED', 'PENDING_RETURN']))
                                        <div x-data="{ returnOpen: false }" class="flex flex-col items-end gap-1">
                                            @if($borrowing->status === 'PENDING_RETURN')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-orange-100 px-2 py-0.5 text-[10px] font-bold text-orange-700">User mengajukan pengembalian</span>
                                            @endif
                                            <button @click="returnOpen = true" type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Verifikasi
                                            </button>

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
                                        <span class="text-slate-300">-</span>
                                    @endif
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="h-12 w-12 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-sm font-medium">Belum ada aktivitas peminjaman</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.04)] ring-1 ring-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Histori Peminjaman</h3>
                        <p class="text-xs font-medium text-slate-500">Catatan transaksi yang sudah selesai atau ditolak.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                    <thead class="bg-slate-50/50 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Barang</th>
                            <th class="px-6 py-4">Rute</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($historyBorrowings as $borrowing)
                        <tr class="transition-colors hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $borrowing->item_type }}</p>
                                @if(auth()->user()->role === 'it_support')
                                <p class="text-xs text-slate-500">{{ $borrowing->user->name }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-600">{{ $borrowing->originBuilding->code }}</span>
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-bold text-indigo-700">{{ $borrowing->targetBuilding->code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ $borrowing->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $historyStatus = match ($borrowing->status) {
                                        'RETURNED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => 'Selesai'],
                                        'REJECTED' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Ditolak'],
                                        default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => $borrowing->status],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full {{ $historyStatus['bg'] }} px-2.5 py-1 text-xs font-bold {{ $historyStatus['text'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $historyStatus['dot'] }}"></span>
                                    {{ $historyStatus['label'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="h-12 w-12 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm font-medium">Belum ada histori peminjaman</p>
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