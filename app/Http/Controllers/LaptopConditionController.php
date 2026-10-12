<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaptopConditionRequest;
use App\Models\Laptop;
use App\Models\LaptopCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CRUD inspeksi hardware laptop (only admin).
 * Hasil inspeksi ditampilkan ke pembeli lewat halaman detail katalog.
 */
class LaptopConditionController extends Controller
{
    public function index(Request $request): View
    {
        $conditions = LaptopCondition::query()
            ->with('laptop.brand')
            ->search($request->query('q'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('conditions.index', [
            'conditions' => $conditions,
            'uninspectedCount' => Laptop::doesntHave('condition')->count(),
        ]);
    }

    public function create(): View
    {
        return view('conditions.create', [
            'condition' => new LaptopCondition(),
            // Hanya laptop yang belum punya inspeksi
            'laptops' => Laptop::doesntHave('condition')->with('brand')->orderBy('model_name')->get(),
        ]);
    }

    public function store(LaptopConditionRequest $request): RedirectResponse
    {
        LaptopCondition::create($request->validated());

        return redirect()->route('conditions.index')->with('success', 'Inspeksi berhasil ditambahkan.');
    }

    public function edit(LaptopCondition $condition): View
    {
        return view('conditions.edit', ['condition' => $condition->load('laptop.brand')]);
    }

    public function update(LaptopConditionRequest $request, LaptopCondition $condition): RedirectResponse
    {
        $condition->update($request->validated());

        return redirect()->route('conditions.index')->with('success', 'Inspeksi berhasil diperbarui.');
    }

    public function destroy(LaptopCondition $condition): RedirectResponse
    {
        $condition->delete();

        return redirect()->route('conditions.index')->with('success', 'Inspeksi berhasil dihapus.');
    }
}
