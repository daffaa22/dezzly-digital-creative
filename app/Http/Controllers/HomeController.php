<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PortfolioItem;
use App\Models\RentalItem;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the main landing page.
     */
    public function index(): View
    {
        $cameras = RentalItem::where('category', 'camera')
            ->where('is_available', true)
            ->get();

        $lenses = RentalItem::where('category', 'lens')
            ->where('is_available', true)
            ->get();

        $packages = Package::where('is_active', true)
            ->orderByRaw('CASE WHEN price_daily = 0 THEN 99999999 ELSE price_daily END ASC')
            ->get();

        $portfolios = PortfolioItem::orderBy('sort_order', 'asc')
            ->get();

        return view('home', compact('cameras', 'lenses', 'packages', 'portfolios'));
    }
}
