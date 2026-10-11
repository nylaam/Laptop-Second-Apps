<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-form-input label="Nama Merek" name="brand_name" :value="$brand->brand_name" required autofocus />

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('brands.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</form>
