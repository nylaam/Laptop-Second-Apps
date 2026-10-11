<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Merek</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow sm:px-8">
            @include('brands._form', [
                'action' => route('brands.store'),
                'method' => 'POST',
                'submitLabel' => 'Simpan',
            ])
        </div>
    </div>
</x-app-layout>
