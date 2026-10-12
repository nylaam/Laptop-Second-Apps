{{--
    Form inspeksi, dipakai bareng oleh create & edit.
    Variabel: $action, $method, $submitLabel, $condition, dan $laptops (khusus create).
--}}
<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($condition->exists)
        {{-- Saat ubah: laptop hanya ditampilkan, tidak bisa diganti --}}
        <div>
            <span class="block text-sm font-medium text-gray-700">Laptop</span>
            <p class="mt-1 text-gray-900">{{ $condition->laptop->brand->brand_name }} {{ $condition->laptop->model_name }}</p>
        </div>
    @else
        {{-- Saat tambah: pilih laptop yang belum diinspeksi --}}
        <div>
            <label for="laptop_id" class="block text-sm font-medium text-gray-700">Laptop</label>
            <select id="laptop_id" name="laptop_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Pilih laptop...</option>
                @foreach ($laptops as $laptop)
                    <option value="{{ $laptop->id }}" @selected((int) old('laptop_id') === $laptop->id)>
                        {{ $laptop->brand->brand_name }} {{ $laptop->model_name }}
                    </option>
                @endforeach
            </select>
            @if ($laptops->isEmpty())
                <p class="mt-1 text-sm text-gray-500">Semua laptop sudah diinspeksi.</p>
            @endif
            @error('laptop_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <x-form-input label="Kesehatan Baterai (angka 0-100 diikuti %)" name="battery_health" :value="$condition->battery_health" required placeholder="mis. 85%" />
    <x-form-input label="Kondisi Layar" name="screen_condition" :value="$condition->screen_condition" required placeholder="mis. Mulus, tanpa dead pixel" />
    <x-form-input label="Status Keyboard" name="keyboard_status" :value="$condition->keyboard_status" required placeholder="mis. Semua tombol normal" />

    <div>
        <label for="minus_note" class="block text-sm font-medium text-gray-700">Catatan Minus (opsional)</label>
        <textarea id="minus_note" name="minus_note" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('minus_note', $condition->minus_note) }}</textarea>
        @error('minus_note')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('conditions.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</form>
