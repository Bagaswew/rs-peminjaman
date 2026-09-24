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

<body class="font-sans text-slate-900 antialiased">
    <div class="min-h-screen bg-slate-50 lg:grid lg:grid-cols-[minmax(360px,0.85fr)_1.15fr]">
        <aside
            class="relative hidden overflow-hidden bg-slate-950 px-10 py-10 text-white lg:flex lg:flex-col lg:justify-between xl:px-16">
            <div class="absolute -right-24 top-24 h-72 w-72 rounded-full border border-sky-500/20"></div>
            <div class="absolute -right-12 top-36 h-48 w-48 rounded-full border border-sky-500/20"></div>
            <div class="relative"><a href="/" class="flex items-center gap-3"><span
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600"><svg class="h-5 w-5"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M12 6v12m-6-6h12M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                        </svg></span><span><span class="block text-sm font-bold">MedAsset</span><span
                            class="block text-[10px] uppercase tracking-[0.18em] text-slate-500">Hospital
                            IT</span></span></a></div>
            <div class="relative max-w-md">
                <p class="text-sm font-medium text-sky-400">IT asset operations</p>
                <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight text-white">Setiap aset tercatat dengan
                    jelas.
                </h1>
                <p class="mt-5 max-w-sm text-sm leading-6 text-slate-400">Kelola peminjaman aset IT antar-gedung dengan
                    kontrol yang jelas, cepat, dan siap diaudit.</p>
                <div class="mt-8 grid grid-cols-2 gap-3 text-xs">
                    <div class="border-l-2 border-sky-500 pl-3">
                        <p class="font-semibold text-slate-200">Kendali terpusat</p>
                        <p class="mt-1 text-slate-500">Satu sumber kebenaran aset</p>
                    </div>
                    <div class="border-l-2 border-emerald-500 pl-3">
                        <p class="font-semibold text-slate-200">Mudah dilacak</p>
                        <p class="mt-1 text-slate-500">Status dan unit terverifikasi</p>
                    </div>
                </div>
            </div>
            <div class="relative flex items-center justify-between text-xs text-slate-500"><span>Ruang kerja IT Rumah
                    Sakit</span><span class="flex items-center gap-2"><span
                        class="h-2 w-2 rounded-full bg-emerald-400"></span>Berjalan normal</span></div>
        </aside>
        <main class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-8">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center gap-3 lg:hidden"><span
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-700 text-white"><svg
                            class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M12 6v12m-6-6h12M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                        </svg></span><span class="text-sm font-bold text-slate-900">MedAsset</span></div>
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">{{ $slot }}</div>
                <p class="mt-6 text-center text-xs text-slate-400">Authorized hospital personnel only · MedAsset</p>
            </div>
    </div>
</body>

</html>