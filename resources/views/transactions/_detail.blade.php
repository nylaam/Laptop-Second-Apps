{{--
    Rincian satu transaksi, dipakai bersama oleh halaman pembeli dan admin.
    Variabel: $transaction (dengan relasi laptop.brand dan user).
--}}
<div class="space-y-4 rounded-lg bg-white p-6 shadow">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Transaksi #{{ $transaction->id }}</p>
            <h3 class="text-lg font-semibold text-gray-900">
                {{ $transaction->laptop->brand->brand_name }} {{ $transaction->laptop->model_name }}
            </h3>
        </div>
        <x-status-badge :status="$transaction->status" />
    </div>

    <dl class="grid grid-cols-3 gap-y-2 text-sm">
        <dt class="text-gray-500">Pembeli</dt>
        <dd class="col-span-2">{{ $transaction->user->name }}</dd>

        <dt class="text-gray-500">Tanggal</dt>
        <dd class="col-span-2">{{ $transaction->transaction_date->format('d M Y') }}</dd>

        <dt class="text-gray-500">Metode</dt>
        <dd class="col-span-2">{{ $transaction->payment_method->value }}</dd>

        <dt class="text-gray-500">Total</dt>
        <dd class="col-span-2 font-semibold text-gray-900">{{ $transaction->formatted_total }}</dd>

        <dt class="text-gray-500">Status laptop</dt>
        <dd class="col-span-2"><x-status-badge :status="$transaction->laptop->status" /></dd>
    </dl>

    @if ($transaction->payment_method->requiresProof())
        <div class="border-t pt-4">
            <h4 class="mb-2 text-sm font-semibold text-gray-900">Bukti Transfer</h4>

            @if ($transaction->hasProof())
                <a href="{{ route('transactions.proof.show', $transaction) }}" target="_blank" rel="noopener">
                    <img src="{{ route('transactions.proof.show', $transaction) }}" alt="Bukti transfer"
                         class="max-h-64 rounded-md border object-contain">
                </a>
            @else
                <p class="text-sm text-gray-500">Belum ada bukti transfer.</p>
            @endif
        </div>
    @endif
</div>
