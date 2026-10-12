<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Inspeksi</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow sm:px-8">
            @include('conditions._form', [
                'action' => route('conditions.store'),
                'method' => 'POST',
                'submitLabel' => 'Simpan',
            ])
        </div>
    </div>
</x-app-layout>
