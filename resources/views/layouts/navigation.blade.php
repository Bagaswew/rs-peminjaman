<aside x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-slate-950/40 lg:hidden"></aside>
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-950 text-slate-300 transition-transform duration-200">
    <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-600 text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                    d="M12 6v12m-6-6h12M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold tracking-tight text-white">MedAsset</p>
            <p class="text-[10px] uppercase tracking-[0.18em] text-slate-500">IT Rumah Sakit</p>
        </div>
        <button @click="sidebarOpen = false" class="ml-auto rounded-md p-1 text-slate-500 hover:bg-white/10 lg:hidden"
            aria-label="Tutup menu">&times;</button>
    </div>

    <div class="flex-1 space-y-7 overflow-y-auto px-3 py-6">
        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Ruang kerja</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><svg
                        class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                            d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10Z" />
                    </svg>Ringkasan</a>
                @if (auth()->user()->role === 'user_gedung')
                    <a href="{{ route('borrowings.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium {{ request()->routeIs('borrowings.*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><svg
                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 5h16v14H4zM8 9h8M8 13h5" />
                        </svg>Pengajuan saya</a>
                @else
                    <a href="{{ route('admin.borrowings.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.borrowings.*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><svg
                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 5h16v14H4zM8 9h8M8 13h5" />
                        </svg>Antrean pengajuan</a>
                    <a href="{{ route('admin.assets.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.assets.*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><svg
                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 7h16M4 12h16M4 17h10" />
                        </svg>Daftar aset</a>
                    <a href="{{ route('admin.buildings.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.buildings.*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><svg
                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 21V5l8-2 8 2v16M8 9h1m6 0h1M8 13h1m6 0h1M8 17h1m6 0h1" />
                        </svg>Gedung</a>
                @endif
            </div>
        </div>
        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Akun</p>
            <div class="mt-2 space-y-1"><a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white"><svg
                        class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                            d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 9a7 7 0 0 0-14 0" />
                    </svg>Profil</a></div>
        </div>
    </div>

    <div class="border-t border-white/10 p-4">
        <div class="rounded-lg bg-white/5 p-3">
            <p class="text-xs font-medium text-slate-300">Status operasional</p>
            <div class="mt-2 flex items-center gap-2 text-xs text-emerald-400"><span
                    class="h-2 w-2 rounded-full bg-emerald-400"></span>Sistem berjalan normal</div>
        </div>
    </div>
</aside>