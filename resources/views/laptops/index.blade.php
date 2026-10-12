<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Inventaris Laptop</h2>
            <a href="{{ route('laptops.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                + Tambah Laptop
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <form method="GET" action="{{ route('laptops.index') }}" class="flex flex-col gap-2 sm:flex-row">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari model atau prosesor..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                <select name="brand" data-auto-submit
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-44">
                    <option value="">Semua merek</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((int) request('brand') === $brand->id)>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>

                <select name="status" data-auto-submit
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-44">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->value }}</option>
                    @endforeach
                </select>

                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white">Cari</button>
            </form>

            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Laptop</th>
                            <th class="px-4 py-3">Spesifikasi</th>
                            <th class="px-4 py-3 text-right">Harga</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($laptops as $laptop)
                            <tr>
                                <td class="px-4 py-3">
                                    @if ($laptop->image_url)
                                        <img src="{{ $laptop->image_url }}" alt="{{ $laptop->model_name }}" class="h-12 w-16 rounded object-cover" loading="lazy">
                                    @else
                                        <div class="flex h-12 w-16 items-center justify-center rounded bg-gray-100 text-xs text-gray-400">-</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $laptop->model_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $laptop->brand->brand_name }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div>{{ $laptop->processor }}</div>
                                    <div class="text-xs text-gray-500">{{ $laptop->ram_storage }}</div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-medium text-gray-900">{{ $laptop->formatted_price }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$laptop->status" /></td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('catalog.show', $laptop) }}" class="text-gray-600 hover:underline">Lihat</a>
                                        <a href="{{ route('laptops.edit', $laptop) }}" class="text-indigo-600 hover:underline">Ubah</a>
                                        <form method="POST" action="{{ route('laptops.destroy', $laptop) }}"
                                              data-confirm="Hapus laptop {{ $laptop->model_name }}?">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada laptop.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $laptops->links() }}
        </div>
    </div>
</x-app-layout>
