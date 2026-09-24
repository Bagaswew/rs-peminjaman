<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-medium text-sky-700">Akses ruang kerja</p>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Buat akun Anda</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Bergabung dengan tim gedung untuk mengajukan peminjaman aset
            IT.</p>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input id="name" class="mt-2 block w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <x-input-label for="email" value="Email kerja" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <x-input-label for="building_id" value="Gedung penempatan" />
            <select id="building_id" name="building_id" required
                class="mt-2 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
                <option value="">Pilih gedung</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}" @selected(old('building_id') == $building->id)>{{ $building->code }} -
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('building_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" value="Kata sandi" />

            <x-text-input id="password" class="mt-2 block w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <x-input-label for="password_confirmation" value="Konfirmasi kata sandi" />

            <x-text-input id="password_confirmation" class="mt-2 block w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-7 flex items-center justify-between gap-4">
            <a class="text-sm font-medium text-slate-500 hover:text-sky-700" href="{{ route('login') }}">
                Sudah memiliki akun?
            </a>

            <x-primary-button>
                Buat akun
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>