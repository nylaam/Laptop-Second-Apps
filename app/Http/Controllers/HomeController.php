<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const FEATURED_LIMIT = 4;

    public function index(): View
    {
        $laptops = Laptop::query()
            ->with('brand')
            ->available()
            ->latest()
            ->limit(self::FEATURED_LIMIT)
            ->get();

        return view('home', compact('laptops'));
    }
}
