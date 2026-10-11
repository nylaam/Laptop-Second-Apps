@if (session('success'))
    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800" role="alert">
        {{ session('error') }}
    </div>
@endif
