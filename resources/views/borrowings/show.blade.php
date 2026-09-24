<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div class="space-y-1">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                    <span class="font-mono">Ref #{{ str_pad($borrowing->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Detail Pengajuan</h2>
                <p class="text-sm text-slate-500">Informasi lengkap mengenai transaksi peminjaman ini.</p>
            </div>
            <a href="{{ route('borrowings.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl space-y-6">
        @php
            $statusConfig = match ($borrowing->status) {
                'PENDING' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Menunggu Persetujuan', 'desc' => 'Pengajuan Anda sedang menunggu persetujuan IT Support.'],
                'APPROVED' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Disetujui', 'desc' => 'Pengajuan Anda sudah disetujui. Silakan ambil barang di IT Support.'],
                'BORROWED' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'Sedang Dipinjam', 'desc' => 'Barang sedang digunakan dan Anda masih memegangnya.'],
                'PENDING_RETURN' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'dot' => 'bg-orange-500', 'label' => 'Menunggu Pengembalian', 'desc' => 'Anda sudah mengajukan pengembalian. Segera serahkan barang ke IT Support.'],
                'REJECTED' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Ditolak', 'desc' => 'Pengajuan ini ditolak oleh IT Support.'],
                'RETURNED' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-500', 'label' => 'Selesai', 'desc' => 'Transaksi peminjaman ini sudah selesai.'],
                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400', 'label' => 'Status', 'desc' => ''],
            };
        @endphp

        {{-- Status Banner --}}
        <div class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.05)] ring-1 ring-slate-100">
            <div class="{{ $statusConfig['bg'] }} px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span
                            class="flex h-3 w-3 rounded-full {{ $statusConfig['dot'] }} shadow-[0_0_8px_currentColor]"></span>
                        <span
                            class="text-sm font-extrabold {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</span>
                    </div>
                    <span
                        class="text-xs font-medium {{ $statusConfig['text'] }} opacity-75">{{ $borrowing->updated_at->diffForHumans() }}</span>
                </div>
                <p class="mt-1.5 text-xs {{ $statusConfig['text'] }} opacity-80">{{ $statusConfig['desc'] }}</p>
            </div>

            {{-- Aksi User --}}
            @if ($borrowing->status === 'APPROVED')
                <div class="border-t {{ $statusConfig['bg'] }} border-emerald-200 px-6 py-3">
                    <form method="POST" action="{{ route('borrowings.receive', $borrowing) }}" class="inline-block">
                        @csrf @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Konfirmasi bahwa Anda sudah menerima barang secara fisik?')"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Konfirmasi Terima Barang
                        </button>
                    </form>
                </div>
            @elseif ($borrowing->status === 'BORROWED')
                <div class="border-t border-indigo-200 {{ $statusConfig['bg'] }} px-6 py-3">
                    <form method="POST" action="{{ route('borrowings.request-return', $borrowing) }}" class="inline-block">
                        @csrf @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Ajukan pengembalian? Anda harus membawa barang langsung ke IT Support.')"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                            Ajukan Pengembalian
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Detail Informasi --}}
        <div class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.05)] ring-1 ring-slate-100">
            <div class="border-b border-slate-100 bg-slate-50/60 px-6 py-4">
                <h3 class="text-sm font-bold text-slate-900">Informasi Pengajuan</h3>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="grid grid-cols-2 gap-4 px-6 py-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Jenis Barang</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $borrowing->item_type }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Unit Dialokasikan</p>
                        @if ($borrowing->asset)
                            <p class="mt-1 font-mono text-sm font-semibold text-slate-800">
                                {{ $borrowing->asset->serial_number }}</p>
                            <p class="text-xs text-slate-500">{{ $borrowing->asset->name }}</p>
                        @else
                            <p class="mt-1 text-sm italic text-slate-400">Belum dialokasikan</p>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Gedung Asal</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $borrowing->originBuilding->name }}</p>
                        <span
                            class="inline-flex rounded bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] font-bold text-slate-500">{{ $borrowing->originBuilding->code }}</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Gedung Tujuan</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $borrowing->targetBuilding->name }}</p>
                        <span
                            class="inline-flex rounded bg-indigo-100 px-1.5 py-0.5 font-mono text-[10px] font-bold text-indigo-600">{{ $borrowing->targetBuilding->code }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pinjam</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">
                            {{ $borrowing->borrow_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Estimasi Kembali</p>
                        @if ($borrowing->return_date)
                            @php
                                $isOverdue = $borrowing->return_date->isPast() && !in_array($borrowing->status, ['RETURNED']);
                            @endphp
                            <p class="mt-1 text-sm font-semibold {{ $isOverdue ? 'text-rose-600' : 'text-slate-800' }}">
                                {{ $borrowing->return_date->format('d M Y') }}
                                @if ($isOverdue)
                                    <span
                                        class="ml-1 rounded-full bg-rose-100 px-1.5 py-0.5 text-[10px] font-bold text-rose-600">Melewati
                                        tenggat</span>
                                @endif
                            </p>
                        @else
                            <p class="mt-1 text-sm italic text-slate-400">-</p>
                        @endif
                    </div>
                </div>
                @if ($borrowing->notes)
                    <div class="px-6 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Catatan / Alasan</p>
                        <p class="mt-2 rounded-lg bg-slate-50 p-3 text-sm leading-relaxed text-slate-700">
                            {{ $borrowing->notes }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-4 px-6 py-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Dibuat</p>
                        <p class="mt-1 text-xs text-slate-600">{{ $borrowing->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Terakhir Diperbarui</p>
                        <p class="mt-1 text-xs text-slate-600">{{ $borrowing->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>