<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $brands = Brand::query()
            ->withCount('laptops')
            ->search($request->query('q'))
            ->orderBy('brand_name')
            ->paginate(10)
            ->withQueryString();

        return view('brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('brands.create', ['brand' => new Brand()]);
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        Brand::create($request->validated());

        return redirect()->route('brands.index')->with('success', 'Merek berhasil ditambahkan.');
    }

    public function edit(Brand $brand): View
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return redirect()->route('brands.index')->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->laptops()->exists()) {
            return back()->with('error', 'Merek tidak bisa dihapus karena masih memiliki laptop.');
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Merek berhasil dihapus.');
    }
}
