<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-50">
        @include('layouts.navigation')
        <div class="lg:pl-64">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true"
                            class="rounded-md p-2 text-slate-500 hover:bg-slate-100 lg:hidden"
                            aria-label="Buka menu"><svg class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg></button>
                        <div class="hidden sm:block">
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Rumah Sakit</p>
                            <p class="text-sm font-semibold text-slate-800">Operasional Aset IT</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @if (auth()->user()->building)<span
                            class="hidden items-center gap-2 border-r border-slate-200 pr-3 text-xs text-slate-500 sm:flex"><span
                                class="h-2 w-2 rounded-full bg-emerald-500"></span>{{ auth()->user()->building->code }}
                        · {{ auth()->user()->building->name }}</span>@endif
                        <span
                            class="rounded-md bg-sky-50 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-sky-700">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                        <x-dropdown align="right" width="48"><x-slot name="trigger"><button
                                    class="flex items-center gap-2 rounded-md p-1.5 hover:bg-slate-100"><span
                                        class="flex h-8 w-8 items-center justify-center rounded-md bg-slate-900 text-xs font-semibold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span
                                        class="hidden text-left sm:block"><span
                                            class="block text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span><span
                                            class="block text-xs text-slate-400">Pengaturan akun</span></span><svg
                                        class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="m6 9 6 6 6-6" />
                                    </svg></button></x-slot><x-slot name="content"><x-dropdown-link
                                    :href="route('profile.edit')">Profil</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link
                                        :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                                </form>
                            </x-slot></x-dropdown>
                    </div>
                </div>
            </header>
            @isset($header)
                <div class="border-b border-slate-200 bg-white">
                    <div class="px-4 py-6 sm:px-6 lg:px-8">{{ $header }}</div>
            </div>@endisset
            <main class="px-4 py-6 sm:px-6 lg:px-8">{{ $slot }}</main>
        </div>
    </div>
</body>

</html>