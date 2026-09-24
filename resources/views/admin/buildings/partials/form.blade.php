<div class="space-y-5">
    <div>
        <label for="code" class="block text-sm font-bold text-slate-700">Kode Gedung <span class="text-rose-500">*</span></label>
        <p class="mt-0.5 text-xs text-slate-500">Kode singkat unik (Cth: GDA, GDB, RSLT)</p>
        <x-text-input id="code" name="code" class="mt-2 block w-full rounded-xl font-mono uppercase" :value="old('code', $building?->code)" required placeholder="Cth: GDA" />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>

    <div>
        <label for="name" class="block text-sm font-bold text-slate-700">Nama Gedung <span class="text-rose-500">*</span></label>
        <x-text-input id="name" name="name" class="mt-2 block w-full rounded-xl" :value="old('name', $building?->name)" required placeholder="Cth: Gedung A – Administrasi" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
</div>