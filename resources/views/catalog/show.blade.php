<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $laptop->brand->brand_name }} {{ $laptop->model_name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <x-flash-message />
        </div>

        <div class="mx-auto grid max-w-5xl gap-8 sm:px-6 md:grid-cols-2 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-gray-100 shadow">
                @if ($laptop->image_url)
                    <img src="{{ $laptop->image_url }}" alt="{{ $laptop->model_name }}" class="w-full object-cover">
                @else
                    <div class="flex aspect-video items-center justify-center text-gray-400">Tanpa foto</div>
                @endif
            </div>

            <div class="space-y-6 rounded-lg bg-white p-6 shadow">
                <div class="flex items-start justify-between gap-4">
                    <p class="text-2xl font-bold text-gray-900">{{ $laptop->formatted_price }}</p>
                    <x-status-badge :status="$laptop->status" />
                </div>

                <dl class="grid grid-cols-3 gap-y-2 text-sm">
                    <dt class="text-gray-500">Merek</dt><dd class="col-span-2">{{ $laptop->brand->brand_name }}</dd>
                    <dt class="text-gray-500">Prosesor</dt><dd class="col-span-2">{{ $laptop->processor }}</dd>
                    <dt class="text-gray-500">RAM / Storage</dt><dd class="col-span-2">{{ $laptop->ram_storage }}</dd>
                </dl>

                @if ($laptop->description)
                    <p class="text-sm text-gray-700">{{ $laptop->description }}</p>
                @endif

                <div>
                    <h3 class="mb-2 font-semibold text-gray-900">Hasil Inspeksi</h3>
                    @if ($laptop->condition)
                        <dl class="grid grid-cols-3 gap-y-2 text-sm">
                            <dt class="text-gray-500">Baterai</dt><dd class="col-span-2">{{ $laptop->condition->battery_health }}</dd>
                            <dt class="text-gray-500">Layar</dt><dd class="col-span-2">{{ $laptop->condition->screen_condition }}</dd>
                            <dt class="text-gray-500">Keyboard</dt><dd class="col-span-2">{{ $laptop->condition->keyboard_status }}</dd>
                            <dt class="text-gray-500">Catatan minus</dt><dd class="col-span-2">{{ $laptop->condition->minus_note ?: '-' }}</dd>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500">Belum ada hasil inspeksi.</p>
                    @endif
                </div>

                @if ($laptop->status === \App\Enums\LaptopStatus::Tersedia && auth()->user()->can('create', \App\Models\Transaction::class))
                    <a href="{{ route('transactions.create', $laptop) }}"
                       class="block rounded-md bg-indigo-600 px-4 py-2 text-center font-semibold text-white hover:bg-indigo-500">
                        Booking Sekarang
                    </a>
                @endif

                <a href="{{ route('catalog.index') }}" class="block text-sm text-gray-600 hover:underline">&larr; Kembali ke katalog</a>
            </div>
        </div>
    </div>
</x-app-layout>
