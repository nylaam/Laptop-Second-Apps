<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Transaksi Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Laptop</th>
                            <th class="px-4 py-3">Metode</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-600">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $transaction->laptop->model_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $transaction->laptop->brand->brand_name }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $transaction->payment_method->value }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-medium text-gray-900">{{ $transaction->formatted_total }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$transaction->status" /></td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada transaksi. <a href="{{ route('catalog.index') }}" class="text-indigo-600 hover:underline">Lihat katalog</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
