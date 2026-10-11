<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $laptops = Laptop::query()
            ->with('brand')
            ->search($request->query('q'))
            ->ofBrand($request->integer('brand') ?: null)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $brands = Brand::orderBy('brand_name')->get(['id', 'brand_name']);

        return view('catalog.index', compact('laptops', 'brands'));
    }

    public function show(Laptop $laptop): View
    {
        $laptop->load(['brand', 'condition']);

        return view('catalog.show', compact('laptop'));
    }
}
