<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Booking Laptop</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
            <x-flash-message />

            {{-- Ringkasan laptop yang akan di-booking --}}
            <div class="flex gap-4 rounded-lg bg-white p-4 shadow">
                <div class="h-24 w-32 shrink-0 overflow-hidden rounded bg-gray-100">
                    @if ($laptop->image_url)
                        <img src="{{ $laptop->image_url }}" alt="{{ $laptop->model_name }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">{{ $laptop->brand->brand_name }}</p>
                    <h3 class="font-semibold text-gray-900">{{ $laptop->model_name }}</h3>
                    <p class="text-sm text-gray-500">{{ $laptop->processor }} &middot; {{ $laptop->ram_storage }}</p>
                    <p class="mt-1 font-bold text-gray-900">{{ $laptop->formatted_price }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('transactions.store', $laptop) }}" class="space-y-6 rounded-lg bg-white p-6 shadow">
                @csrf

                <fieldset>
                    <legend class="text-sm font-medium text-gray-700">Metode pembayaran</legend>

                    <div class="mt-2 space-y-2">
                        @foreach ($paymentMethods as $method)
                            <label class="flex cursor-pointer items-start gap-3 rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="{{ $method->value }}" required
                                       @checked(old('payment_method') === $method->value)
                                       class="mt-1 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $method->value }}</span>
                                    <span class="block text-sm text-gray-500">{{ $method->description() }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                <p class="text-sm text-gray-500">
                    Setelah booking, laptop ditahan untukmu dan tidak bisa dipesan pengguna lain
                    sampai admin memproses atau membatalkan transaksi.
                </p>

                <div class="flex items-center gap-3">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Konfirmasi Booking
                    </button>
                    <a href="{{ route('catalog.show', $laptop) }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
