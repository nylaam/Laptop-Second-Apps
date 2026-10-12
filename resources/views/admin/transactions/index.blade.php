<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Transaksi</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-4 sm:px-6 lg:px-8">
            <x-flash-message />

            {{-- Ringkasan jumlah transaksi per status --}}
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($statuses as $status)
                    <a href="{{ route('admin.transactions.index', ['status' => $status->value]) }}"
                       class="rounded-lg bg-white p-4 shadow hover:shadow-md">
                        <x-status-badge :status="$status" />
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $statusCounts[$status->value] ?? 0 }}</p>
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-col gap-2 sm:flex-row">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama pembeli atau model laptop..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

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
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Pembeli</th>
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
                                <td class="px-4 py-3 text-gray-900">{{ $transaction->user->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $transaction->laptop->model_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $transaction->laptop->brand->brand_name }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div>{{ $transaction->payment_method->value }}</div>
                                    @if ($transaction->payment_method->requiresProof())
                                        <div class="text-xs {{ $transaction->hasProof() ? 'text-green-600' : 'text-gray-400' }}">
                                            {{ $transaction->hasProof() ? 'Bukti sudah diunggah' : 'Belum ada bukti' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-medium text-gray-900">{{ $transaction->formatted_total }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$transaction->status" /></td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-indigo-600 hover:underline">Proses</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
