<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="Katalog laptop bekas lengkap dengan hasil inspeksi hardware dan booking COD atau transfer manual.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-800 antialiased">

    <!-- Navbar -->
    <header class="border-b border-gray-100">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="text-lg font-bold text-indigo-600">{{ config('app.name') }}</a>

            <div class="flex items-center gap-3 text-sm font-medium">
                @auth
                    <a href="{{ route('catalog.index') }}"
                       class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500">Buka Katalog</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Masuk</a>
                    <a href="{{ route('register') }}"
                       class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero section -->
    <section class="bg-gradient-to-b from-indigo-50 to-white">
        <div class="mx-auto max-w-6xl px-4 py-20 text-center sm:px-6 lg:px-8 lg:py-28">
            <h1 class="mx-auto max-w-3xl text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                Laptop bekas berkualitas, <span class="text-indigo-600">kondisinya jelas</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-600">
                Lihat spesifikasi, hasil inspeksi baterai, layar, dan keyboard sebelum memutuskan.
                Booking mudah, bayar lewat COD atau transfer manual.
            </p>

            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('catalog.index') }}"
                   class="w-full rounded-md bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-500 sm:w-auto">
                    Lihat Katalog
                </a>
                @guest
                    <a href="{{ route('register') }}"
                       class="w-full rounded-md border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50 sm:w-auto">
                        Buat Akun
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Web Knowledge -->
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl font-bold text-gray-900">Kenapa {{ config('app.name') }}?</h2>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['Inspeksi transparan', 'Setiap unit diperiksa teknisi. Kondisi baterai, layar, keyboard, dan catatan minus ditampilkan apa adanya.'],
                ['Status stok jelas', 'Tersedia, Terbooking, atau Terjual selalu terlihat, sehingga unit yang sama tidak dipesan dua kali.'],
                ['Pembayaran fleksibel', 'Pilih COD atau transfer manual. Admin memverifikasi setiap pembayaran sebelum transaksi selesai.'],
            ] as [$title, $text])
                <div class="rounded-lg border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-gray-50">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-bold text-gray-900">Cara booking</h2>

            <ol class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ([
                    'Pilih laptop dari katalog dan cek hasil inspeksinya.',
                    'Booking unit yang tersedia, lalu pilih COD atau transfer manual.',
                    'Admin memproses pesananmu. Untuk transfer, unggah bukti pembayaran.',
                ] as $index => $step)
                    <li class="flex gap-4">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                            {{ $index + 1 }}
                        </span>
                        <p class="text-gray-700">{{ $step }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @if ($laptops->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Baru ditambahkan</h2>
                <a href="{{ route('catalog.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($laptops as $laptop)
                    <x-laptop-card :laptop="$laptop" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Footer --}}
    <footer class="border-t border-gray-100">
        <div class="mx-auto max-w-6xl px-4 py-8 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Proyek mata kuliah Pengembangan Aplikasi Web.
        </div>
    </footer>

</body>
</html>
