<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div class="space-y-1">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-sky-50 border border-sky-100 px-3 py-1 text-xs font-semibold text-sky-600">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Formulir Baru
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Buat Pengajuan Peminjaman</h2>
                <p class="text-sm text-slate-500">Isi detail di bawah. Permintaan akan diverifikasi oleh IT Support.</p>
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

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('borrowings.store') }}"
            class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.06)] ring-1 ring-slate-100">
            @csrf

            {{-- Form Header --}}
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-5 sm:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Detail Pengajuan</p>
                        <p class="text-xs text-slate-500">Semua field wajib diisi kecuali catatan.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-6 sm:p-8">
                {{-- Gedung Asal --}}
                <div>
                    <label for="origin_building_id" class="block text-sm font-bold text-slate-700">Gedung Asal Barang
                        <span class="text-rose-500">*</span></label>
                    <p class="mt-0.5 text-xs text-slate-500">Pilih gedung tempat aset yang ingin dipinjam berada.</p>
                    <select id="origin_building_id" name="origin_building_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 bg-white text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500">
                        <option value="">— Pilih gedung —</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" @selected(old('origin_building_id') == $building->id)>
                                {{ $building->code }} · {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('origin_building_id')" class="mt-2" />
                </div>

                {{-- Jenis Barang --}}
                <div>
                    <label for="item_type" class="block text-sm font-bold text-slate-700">Jenis Barang <span
                            class="text-rose-500">*</span></label>
                    <p class="mt-0.5 text-xs text-slate-500">Dimuat otomatis berdasarkan aset tersedia di gedung yang
                        dipilih.</p>
                    <div class="relative mt-2">
                        <select id="item_type" name="item_type" required disabled
                            class="block w-full rounded-xl border-slate-200 text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400">
                            <option value="">Pilih gedung asal terlebih dahulu</option>
                        </select>
                        <div id="asset-loading" class="mt-2 hidden items-center gap-2 text-xs font-medium text-sky-700">
                            <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Memuat daftar barang tersedia...
                        </div>
                    </div>
                    <p id="asset-empty" class="mt-2 hidden text-xs font-medium text-amber-700">⚠ Tidak ada aset tersedia
                        di gedung ini.</p>
                    <p id="asset-error" class="mt-2 hidden text-xs font-medium text-rose-700">✕ Gagal memuat daftar
                        aset. Silakan coba lagi.</p>
                    <x-input-error :messages="$errors->get('item_type')" class="mt-2" />
                </div>

                {{-- Gedung Tujuan --}}
                <div>
                    <label for="target_building_id" class="block text-sm font-bold text-slate-700">Gedung Tujuan</label>
                    <p class="mt-0.5 text-xs text-slate-500">Otomatis diisi berdasarkan gedung akun Anda.</p>
                    <select id="target_building_id" name="target_building_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50/80 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        @if ($targetBuilding)
                            <option value="{{ $targetBuilding->id }}" selected>{{ $targetBuilding->code }} ·
                                {{ $targetBuilding->name }}</option>
                        @else
                            <option value="">Gedung Anda belum dikonfigurasi</option>
                        @endif
                    </select>
                    <x-input-error :messages="$errors->get('target_building_id')" class="mt-2" />
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-bold text-slate-700">Jumlah Unit <span
                            class="text-rose-500">*</span></label>
                    <p class="mt-0.5 text-xs text-slate-500">Masukkan jumlah unit yang ingin dipinjam. Jumlah tidak
                        boleh melebihi stok tersedia.</p>
                    <input id="quantity" name="quantity" type="number" min="1" max="100" required
                        value="{{ old('quantity', 1) }}"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500">
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>

                {{-- Tanggal --}}
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="borrow_date" class="block text-sm font-bold text-slate-700">Tanggal Pinjam <span
                                class="text-rose-500">*</span></label>
                        <input id="borrow_date" name="borrow_date" type="date" required
                            value="{{ old('borrow_date', today()->toDateString()) }}"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500">
                        <x-input-error :messages="$errors->get('borrow_date')" class="mt-2" />
                    </div>
                    <div>
                        <label for="return_date" class="block text-sm font-bold text-slate-700">Estimasi Kembali <span
                                class="text-rose-500">*</span></label>
                        <input id="return_date" name="return_date" type="date" required value="{{ old('return_date') }}"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500">
                        <x-input-error :messages="$errors->get('return_date')" class="mt-2" />
                    </div>
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="notes" class="block text-sm font-bold text-slate-700">Alasan / Catatan</label>
                    <p class="mt-0.5 text-xs text-slate-500">Opsional. Jelaskan kebutuhan atau hal penting yang perlu
                        diketahui IT Support.</p>
                    <textarea id="notes" name="notes" rows="4" maxlength="2000"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-sm shadow-sm transition-colors focus:border-sky-500 focus:ring-sky-500"
                        placeholder="Contoh: Dibutuhkan untuk keperluan operasional Ruang ICU lantai 3...">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="flex flex-col-reverse items-center gap-3 border-t border-slate-100 bg-slate-50/60 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
                <a href="{{ route('borrowings.index') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition-colors sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                    class="group relative w-full overflow-hidden rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 sm:w-auto">
                    <span class="relative flex items-center justify-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-6-6 6 6-6 6"></path>
                        </svg>
                        Kirim Pengajuan
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            const originSelect = document.getElementById('origin_building_id');
            const itemSelect = document.getElementById('item_type');
            const loadingEl = document.getElementById('asset-loading');
            const emptyEl = document.getElementById('asset-empty');
            const errorEl = document.getElementById('asset-error');
            const selectedItem = @json(old('item_type'));

            const show = (el, visible) => el.classList.toggle('hidden', !visible);
            const flex = (el, visible) => { el.classList.toggle('hidden', !visible); el.classList.toggle('flex', visible); };

            const reset = () => {
                itemSelect.innerHTML = '<option value="">Pilih gedung asal terlebih dahulu</option>';
                itemSelect.disabled = true;
                show(emptyEl, false);
                show(errorEl, false);
            };

            originSelect.addEventListener('change', async () => {
                const id = originSelect.value;
                reset();
                flex(loadingEl, Boolean(id));
                if (!id) { flex(loadingEl, false); return; }

                try {
                    const res = await fetch(`{{ url('/borrowings/assets') }}/${id}`, {
                        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    });
                    if (!res.ok) throw new Error();
                    const { data } = await res.json();
                    itemSelect.innerHTML = '<option value="">— Pilih jenis barang —</option>';
                    data.forEach(({ name, available_count }) => {
                        itemSelect.add(new Option(`${name} — ${available_count} unit tersedia`, name, false, name === selectedItem));
                    });
                    itemSelect.disabled = data.length === 0;
                    show(emptyEl, data.length === 0);
                } catch {
                    show(errorEl, true);
                } finally {
                    flex(loadingEl, false);
                }
            });

            if (originSelect.value) originSelect.dispatchEvent(new Event('change'));

            const borrowDate = document.getElementById('borrow_date');
            const returnDate = document.getElementById('return_date');
            const syncMin = () => { returnDate.min = borrowDate.value; };
            borrowDate.addEventListener('change', syncMin);
            syncMin();
        })();
    </script>
</x-app-layout>