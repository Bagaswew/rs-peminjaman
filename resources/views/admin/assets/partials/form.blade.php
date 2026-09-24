<div class="space-y-5">
    <div>
        <label for="asset_code" class="block text-sm font-bold text-slate-700">Kode Aset <span
                class="text-rose-500">*</span></label>
        <x-text-input id="asset_code" name="asset_code" class="mt-2 block w-full rounded-xl" :value="old('asset_code', $asset?->asset_code)" required placeholder="Cth: AST-001" />
        <x-input-error :messages="$errors->get('asset_code')" class="mt-2" />
    </div>

    <div>
        <label for="name" class="block text-sm font-bold text-slate-700">Jenis Aset <span
                class="text-rose-500">*</span></label>
        <p class="mt-0.5 text-xs text-slate-500">Nama kategori barang (Laptop, Keyboard, Proyektor, dll)</p>
        <x-text-input id="name" name="name" class="mt-2 block w-full rounded-xl" :value="old('name', $asset?->name)"
            required placeholder="Cth: Laptop Dell Latitude" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <label for="serial_number" class="block text-sm font-bold text-slate-700">Serial Number <span
                class="text-rose-500">*</span></label>
        <x-text-input id="serial_number" name="serial_number" class="mt-2 block w-full rounded-xl font-mono"
            :value="old('serial_number', $asset?->serial_number)" required placeholder="Cth: SN-XYZ-123456" />
        <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
    </div>

    @if ($asset === null)
        <div>
            <label for="quantity" class="block text-sm font-bold text-slate-700">Jumlah Unit <span
                    class="text-rose-500">*</span></label>
            <p class="mt-0.5 text-xs text-slate-500">Unit tambahan akan dibuat dengan kode dan serial berurutan otomatis.
            </p>
            <x-text-input id="quantity" name="quantity" type="number" min="1" max="100" class="mt-2 block w-full rounded-xl"
                :value="old('quantity', 1)" required />
            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
        </div>
    @endif

    <div>
        <label for="building_id" class="block text-sm font-bold text-slate-700">Gedung <span
                class="text-rose-500">*</span></label>
        <select id="building_id" name="building_id" required
            class="mt-2 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
            <option value="">— Pilih gedung —</option>
            @foreach ($buildings as $building)
                <option value="{{ $building->id }}" @selected(old('building_id', data_get($asset, 'building_id')) == $building->id)>
                    {{ $building->code }} · {{ $building->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('building_id')" class="mt-2" />
    </div>

</div>