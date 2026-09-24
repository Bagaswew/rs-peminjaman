<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 border border-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-600">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Aset Baru
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Aset</h2>
                <p class="text-sm text-slate-500">Daftarkan unit perangkat IT baru ke dalam sistem inventaris.</p>
            </div>
            <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl">
        <form method="POST" action="{{ route('admin.assets.store') }}"
            class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_rgba(0,0,0,0.06)] ring-1 ring-slate-100">
            @csrf
            <div class="border-b border-slate-100 bg-slate-50/60 px-6 py-5 sm:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Data Aset</p>
                        <p class="text-xs text-slate-500">Semua field bertanda * wajib diisi.</p>
                    </div>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                @include('admin.assets.partials.form', ['asset' => null])
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50/60 px-6 py-4 sm:px-8">
                <a href="{{ route('admin.assets.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-slate-800 hover:-translate-y-0.5 transition-all">Simpan Aset</button>
            </div>
        </form>
    </div>
</x-app-layout>