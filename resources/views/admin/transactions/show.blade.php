<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Proses Transaksi</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
            <x-flash-message />

            @include('transactions._detail')

            {{-- Tombol aksi hanya muncul kalau aksinya memang diizinkan untuk transaksi ini --}}
            <div class="space-y-3 rounded-lg bg-white p-6 shadow">
                <h3 class="font-semibold text-gray-900">Aksi</h3>

                @if ($transaction->payment_method->requiresProof() && $transaction->isPending() && ! $transaction->hasProof())
                    <p class="text-sm text-gray-500">Menunggu pembeli mengunggah bukti transfer.</p>
                @endif

                @unless ($transaction->canBeVerified() || $transaction->canBeCompleted() || $transaction->canBeCancelled())
                    <p class="text-sm text-gray-500">Transaksi sudah final, tidak ada aksi yang tersedia.</p>
                @endunless

                <div class="flex flex-wrap gap-3">
                    @if ($transaction->canBeVerified())
                        <form method="POST" action="{{ route('admin.transactions.verify', $transaction) }}"
                              data-confirm="Tandai pembayaran ini sudah diterima?">
                            @csrf
                            <button class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500">
                                Verifikasi Pembayaran
                            </button>
                        </form>
                    @endif

                    @if ($transaction->canBeCompleted())
                        <form method="POST" action="{{ route('admin.transactions.complete', $transaction) }}"
                              data-confirm="Tandai transaksi COD ini selesai?">
                            @csrf
                            <button class="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-500">
                                Selesaikan COD
                            </button>
                        </form>
                    @endif

                    @if ($transaction->canBeCancelled())
                        <form method="POST" action="{{ route('admin.transactions.cancel', $transaction) }}"
                              data-confirm="Batalkan booking ini? Laptop akan kembali Tersedia.">
                            @csrf
                            <x-danger-button>Batalkan Booking</x-danger-button>
                        </form>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.transactions.index') }}" class="block text-sm text-gray-600 hover:underline">&larr; Kembali ke daftar transaksi</a>
        </div>
    </div>
</x-app-layout>
