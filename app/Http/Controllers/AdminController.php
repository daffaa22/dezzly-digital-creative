<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PortfolioItem;
use App\Models\RentalItem;
use App\Models\RentalOrder;
use App\Models\ServiceInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalOrders = RentalOrder::count();
        $totalInquiries = ServiceInquiry::count();
        $totalRevenue = RentalOrder::where('status', 'confirmed')->sum('total_price');
        $availableCameras = RentalItem::where('category', 'camera')->where('is_available', true)->count();

        $rentalOrders = RentalOrder::with(['camera', 'lens'])
            ->latest()
            ->take(20)
            ->get();

        $serviceInquiries = ServiceInquiry::with('package')
            ->latest()
            ->take(20)
            ->get();

        $rentalItems = RentalItem::orderBy('category')->orderBy('name')->get();
        $packages = Package::all();
        $portfolios = PortfolioItem::orderBy('sort_order')->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalInquiries',
            'totalRevenue',
            'availableCameras',
            'rentalOrders',
            'serviceInquiries',
            'rentalItems',
            'packages',
            'portfolios'
        ));
    }

    /**
     * Update status of a rental order.
     */
    public function updateOrderStatus(Request $request, RentalOrder $order): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,active,returned,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', "Status order #{$order->order_code} berhasil diperbarui.");
    }

    /**
     * Update status of a service inquiry.
     */
    public function updateInquiryStatus(Request $request, ServiceInquiry $inquiry): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,quoted,deal,lost'],
        ]);

        $inquiry->update(['status' => $validated['status']]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', "Status inquiry #{$inquiry->inquiry_code} berhasil diperbarui.");
    }

    /**
     * Display a print-ready invoice for a rental order.
     */
    public function printInvoice(RentalOrder $order): View
    {
        $order->load(['camera', 'lens']);

        return view('admin.invoice', compact('order'));
    }

    /**
     * Toggle availability of a rental item.
     */
    public function toggleItemAvailability(RentalItem $item): RedirectResponse
    {
        $item->update(['is_available' => ! $item->is_available]);

        return back()->with('success', "Status ketersediaan {$item->name} berhasil diubah.");
    }
}
