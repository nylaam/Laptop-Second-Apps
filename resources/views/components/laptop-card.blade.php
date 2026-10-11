@props(['laptop'])

{{-- Kartu produk untuk grid katalog. Use with <x-laptop-card :laptop="$laptop" /> --}}
<a href="{{ route('catalog.show', $laptop) }}"
   class="group flex flex-col overflow-hidden rounded-lg bg-white shadow transition hover:shadow-md">
    <div class="aspect-video w-full bg-gray-100">
        @if ($laptop->image_url)
            <img src="{{ $laptop->image_url }}" alt="{{ $laptop->model_name }}" class="h-full w-full object-cover" loading="lazy">
        @else
            <div class="flex h-full items-center justify-center text-sm text-gray-400">Tanpa foto</div>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-1 p-4">
        <span class="text-xs font-medium uppercase tracking-wide text-indigo-600">{{ $laptop->brand->brand_name }}</span>
        <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600">{{ $laptop->model_name }}</h3>
        <p class="text-sm text-gray-500">{{ $laptop->processor }}</p>
        <p class="text-sm text-gray-500">{{ $laptop->ram_storage }}</p>

        <div class="mt-auto flex items-center justify-between pt-3">
            <span class="font-bold text-gray-900">{{ $laptop->formatted_price }}</span>
            <x-status-badge :status="$laptop->status" />
        </div>
    </div>
</a>
