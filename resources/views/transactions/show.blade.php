<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Detail Transaksi</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
            <x-flash-message />

            @include('transactions._detail')

            {{-- Step transaksi untuk pembeli --}}
            <div class="rounded-md bg-gray-50 p-4 text-sm text-gray-700">
                @if ($transaction->canBeCompleted())
                    Siapkan pembayaran saat bertemu. Admin akan menandai transaksi selesai setelah COD dilakukan.
                @elseif ($transaction->canBeVerified())
                    Bukti transfer sudah diterima. Menunggu verifikasi admin.
                @elseif ($transaction->canUploadProof())
                    Silakan transfer sesuai total di atas, lalu unggah bukti transfer.
                @elseif ($transaction->status === \App\Enums\TransactionStatus::Dibatalkan)
                    Booking ini dibatalkan.
                @else
                    Transaksi selesai. Terima kasih sudah berbelanja!
                @endif
            </div>

            @if ($transaction->canUploadProof())
                <form method="POST" action="{{ route('transactions.proof.store', $transaction) }}"
                      enctype="multipart/form-data" class="space-y-4 rounded-lg bg-white p-6 shadow">
                    @csrf

                    <div>
                        <label for="proof" class="block text-sm font-medium text-gray-700">
                            {{ $transaction->hasProof() ? 'Ganti bukti transfer' : 'Unggah bukti transfer' }}
                            (JPG/PNG/WEBP, maks. 2 MB)
                        </label>

                        <div class="mt-2 aspect-video w-full max-w-xs overflow-hidden rounded-md bg-gray-100">
                            <img data-image-preview-target="proof" alt="Pratinjau bukti transfer" class="hidden h-full w-full object-contain">
                            <div data-image-preview-empty class="flex h-full items-center justify-center text-sm text-gray-400">
                                Belum ada file dipilih
                            </div>
                        </div>

                        <input id="proof" name="proof" type="file" required accept="image/jpeg,image/png,image/webp"
                               data-image-preview="[data-image-preview-target=proof]"
                               class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-200">
                        @error('proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Unggah Bukti
                    </button>
                </form>
            @endif

            <a href="{{ route('transactions.index') }}" class="block text-sm text-gray-600 hover:underline">&larr; Kembali ke transaksi saya</a>
        </div>
    </div>
</x-app-layout>
