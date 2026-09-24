<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-medium text-sky-700">Selamat datang kembali</p>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Masuk ke MedAsset</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Akses ruang kerja operasional aset IT rumah sakit.</p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email kerja" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="name@hospital.org" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" value="Kata sandi" />

            <x-text-input id="password" class="mt-2 block w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-5 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox"
                    class="rounded border-slate-300 text-sky-700 shadow-sm focus:ring-sky-500" name="remember">
                <span class="text-sm text-slate-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-slate-500 hover:text-sky-700" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="min-w-28">
                Masuk
            </x-primary-button>
        </div>
    </form>
    @if (Route::has('register'))
        <p class="mt-8 border-t border-slate-100 pt-6 text-center text-sm text-slate-500">Belum memiliki akun? <a
                class="font-semibold text-sky-700 hover:text-sky-900" href="{{ route('register') }}">Buat akun</a>
    </p>@endif
</x-guest-layout>