<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="brand_id" class="block text-sm font-medium text-gray-700">Merek</label>
        <select id="brand_id" name="brand_id" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Pilih merek...</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected((int) old('brand_id', $laptop->brand_id) === $brand->id)>
                    {{ $brand->brand_name }}
                </option>
            @endforeach
        </select>
        @error('brand_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <x-form-input label="Nama Model" name="model_name" :value="$laptop->model_name" required placeholder="mis. ThinkPad T480" />
    <x-form-input label="Prosesor" name="processor" :value="$laptop->processor" required placeholder="mis. Intel Core i5-8350U" />
    <x-form-input label="RAM / Storage" name="ram_storage" :value="$laptop->ram_storage" required placeholder="mis. RAM 8GB / SSD 256GB" />
    <x-form-input label="Harga (Rp)" name="price" type="number" min="1" step="1" :value="$laptop->price" required placeholder="mis. 4500000" />

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $laptop->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Foto (JPG/PNG/WEBP, maks. 2 MB)</label>

        <div class="mt-2 aspect-video w-full max-w-xs overflow-hidden rounded-md bg-gray-100">
            <img data-image-preview-target="image" alt="Pratinjau foto"
                 src="{{ $laptop->image_url }}"
                 class="h-full w-full object-cover {{ $laptop->image_url ? '' : 'hidden' }}">
            <div data-image-preview-empty class="flex h-full items-center justify-center text-sm text-gray-400 {{ $laptop->image_url ? 'hidden' : '' }}">
                Belum ada foto
            </div>
        </div>

        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
               data-image-preview="[data-image-preview-target=image]"
               class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-200">
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if ($laptop->image)
            <label class="mt-2 inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                Hapus foto saat ini
            </label>
        @endif
    </div>

    @if ($laptop->exists)
        <div class="flex items-center gap-2 text-sm text-gray-600">
            Status saat ini: <x-status-badge :status="$laptop->status" />
            <span class="text-xs text-gray-400">(diatur otomatis oleh alur transaksi)</span>
        </div>
    @endif

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('laptops.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</form>
