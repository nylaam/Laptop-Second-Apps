<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Inspeksi Hardware</h2>
            <a href="{{ route('conditions.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                + Tambah Inspeksi
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-4 sm:px-6 lg:px-8">
            <x-flash-message />

            @if ($uninspectedCount > 0)
                <div class="rounded-md bg-yellow-50 p-4 text-sm text-yellow-800">
                    Ada {{ $uninspectedCount }} laptop yang belum diinspeksi.
                </div>
            @endif

            <form method="GET" action="{{ route('conditions.index') }}" class="flex gap-2">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari model atau prosesor laptop..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white">Cari</button>
            </form>

            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Laptop</th>
                            <th class="px-4 py-3">Baterai</th>
                            <th class="px-4 py-3">Layar</th>
                            <th class="px-4 py-3">Keyboard</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($conditions as $condition)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $condition->laptop->model_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $condition->laptop->brand->brand_name }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $condition->battery_health }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $condition->screen_condition }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $condition->keyboard_status }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('catalog.show', $condition->laptop) }}" class="text-gray-600 hover:underline">Lihat</a>
                                        <a href="{{ route('conditions.edit', $condition) }}" class="text-indigo-600 hover:underline">Ubah</a>
                                        <form method="POST" action="{{ route('conditions.destroy', $condition) }}"
                                              data-confirm="Hapus inspeksi {{ $condition->laptop->model_name }}?">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data inspeksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $conditions->links() }}
        </div>
    </div>
</x-app-layout>
