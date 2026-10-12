<?php

namespace App\Http\Controllers;

use App\Enums\LaptopStatus;
use App\Http\Requests\LaptopRequest;
use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * CRUD inventaris laptop (only admin)
 */
class LaptopController extends Controller
{
    public function index(Request $request): View
    {
        $laptops = Laptop::query()
            ->with('brand')
            ->search($request->query('q'))
            ->ofBrand($request->integer('brand') ?: null)
            ->ofStatus($request->query('status'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('laptops.index', [
            'laptops' => $laptops,
            'brands' => Brand::orderBy('brand_name')->get(['id', 'brand_name']),
            'statuses' => LaptopStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('laptops.create', [
            'laptop' => new Laptop(),
            'brands' => Brand::orderBy('brand_name')->get(['id', 'brand_name']),
        ]);
    }

    public function store(LaptopRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('laptops', 'public');
        }

        $data['status'] = LaptopStatus::Tersedia;

        Laptop::create($data);

        return redirect()->route('laptops.index')->with('success', 'Laptop berhasil ditambahkan.');
    }

    public function edit(Laptop $laptop): View
    {
        return view('laptops.edit', [
            'laptop' => $laptop,
            'brands' => Brand::orderBy('brand_name')->get(['id', 'brand_name']),
        ]);
    }

    public function update(LaptopRequest $request, Laptop $laptop): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $oldImage = $laptop->image;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('laptops', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }

        $laptop->update($data);

        if ($oldImage && $oldImage !== $laptop->image) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('laptops.index')->with('success', 'Laptop berhasil diperbarui.');
    }

    public function destroy(Laptop $laptop): RedirectResponse
    {
        if ($laptop->hasTransactionHistory()) {
            return back()->with('error', 'Laptop tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        $image = $laptop->image;
        $laptop->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()->route('laptops.index')->with('success', 'Laptop berhasil dihapus.');
    }
}
