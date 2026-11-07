<?php

namespace App\Http\Controllers;

use App\Models\FaqItem;
use App\Models\Package;
use App\Models\PortfolioItem;
use App\Models\RentalItem;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the main creative studio landing page.
     */
    public function index(): View
    {
        $packages = Package::where('is_active', true)
            ->orderByRaw('CASE WHEN price_daily = 0 THEN 99999999 ELSE price_daily END ASC')
            ->get();

        $portfolios = PortfolioItem::orderBy('sort_order', 'asc')
            ->get();

        $faqs = FaqItem::active()->get();

        $settings = SiteSetting::getAllCached();

        $cameras = RentalItem::where('category', 'camera')
            ->where('is_available', true)
            ->orderBy('daily_price', 'asc')
            ->get();

        $lenses = RentalItem::where('category', 'lens')
            ->where('is_available', true)
            ->orderBy('daily_price', 'asc')
            ->get();

        return view('home', compact('packages', 'portfolios', 'faqs', 'settings', 'cameras', 'lenses'));
    }
}
