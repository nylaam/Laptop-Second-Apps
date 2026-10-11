<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Katalog Laptop</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <x-flash-message />

            <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col gap-2 sm:flex-row">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari model atau prosesor..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="brand" data-auto-submit
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-48">
                    <option value="">Semua merek</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((int) request('brand') === $brand->id)>
                            {{ $brand->brand_name }}
                        </option>
                    @endforeach
                </select>

                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white">Cari</button>
            </form>

            @if ($laptops->isEmpty())
                <p class="py-12 text-center text-gray-500">Tidak ada laptop yang cocok dengan pencarian.</p>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($laptops as $laptop)
                        <x-laptop-card :laptop="$laptop" />
                    @endforeach
                </div>

                {{ $laptops->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
