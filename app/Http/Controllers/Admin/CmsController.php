<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqItem;
use App\Models\Package;
use App\Models\PortfolioItem;
use App\Models\RentalItem;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CmsController extends Controller
{
    /**
     * =========================================================================
     * 1. PENGATURAN TEKS LANDING PAGE & INFO STUDIO
     * =========================================================================
     */
    public function indexSettings(): View
    {
        $settings = SiteSetting::all()->groupBy('group');

        return view('admin.cms.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            $existing = SiteSetting::where('key', $key)->first();
            $group = $existing ? $existing->group : 'general';
            $label = $existing ? $existing->label : null;

            SiteSetting::set($key, is_null($value) ? '' : (string) $value, $group, $label);
        }

        SiteSetting::clearCache();

        return back()->with('success', 'Pengaturan teks dan informasi landing page berhasil diperbarui!');
    }

    /**
     * =========================================================================
     * 2. KELOLA PAKET DOKUMENTASI (CRUD)
     * =========================================================================
     */
    public function indexPackages(): View
    {
        $packages = Package::orderBy('id', 'asc')->get();

        return view('admin.cms.packages', compact('packages'));
    }

    public function storePackage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'base_gear' => 'required|string|max:255',
            'crew_fg_count' => 'required|integer|min:0',
            'crew_vg_count' => 'required|integer|min:0',
            'has_drone' => 'nullable|boolean',
            'turnaround_days' => 'required|integer|min:1',
            'photo_output' => 'required|string|max:255',
            'video_output' => 'required|string|max:255',
            'features_text' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $features = [];
        if (! empty($validated['features_text'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
        }

        $slug = Str::slug($validated['name']);
        if (Package::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        Package::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'subtitle' => $validated['subtitle'] ?? null,
            'price_daily' => 0, // Konsisten dengan konsep harga on request
            'base_gear' => $validated['base_gear'],
            'crew_fg_count' => (int) $validated['crew_fg_count'],
            'crew_vg_count' => (int) $validated['crew_vg_count'],
            'has_drone' => $request->boolean('has_drone'),
            'turnaround_days' => (int) $validated['turnaround_days'],
            'photo_output' => $validated['photo_output'],
            'video_output' => $validated['video_output'],
            'features' => $features,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Paket dokumentasi baru berhasil ditambahkan!');
    }

    public function updatePackage(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'base_gear' => 'required|string|max:255',
            'crew_fg_count' => 'required|integer|min:0',
            'crew_vg_count' => 'required|integer|min:0',
            'has_drone' => 'nullable|boolean',
            'turnaround_days' => 'required|integer|min:1',
            'photo_output' => 'required|string|max:255',
            'video_output' => 'required|string|max:255',
            'features_text' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $features = [];
        if (! empty($validated['features_text'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
        }

        $package->update([
            'name' => $validated['name'],
            'subtitle' => $validated['subtitle'] ?? null,
            'base_gear' => $validated['base_gear'],
            'crew_fg_count' => (int) $validated['crew_fg_count'],
            'crew_vg_count' => (int) $validated['crew_vg_count'],
            'has_drone' => $request->boolean('has_drone'),
            'turnaround_days' => (int) $validated['turnaround_days'],
            'photo_output' => $validated['photo_output'],
            'video_output' => $validated['video_output'],
            'features' => $features,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Paket dokumentasi "'.$package->name.'" berhasil diperbarui!');
    }

    public function deletePackage(Package $package): RedirectResponse
    {
        $name = $package->name;
        $package->delete();

        return back()->with('success', 'Paket "'.$name.'" berhasil dihapus!');
    }

    public function togglePackage(Package $package): RedirectResponse
    {
        $package->update(['is_active' => ! $package->is_active]);

        return back()->with('success', 'Status keaktifan paket "'.$package->name.'" diperbarui!');
    }

    /**
     * =========================================================================
     * 3. KELOLA UNIT RENTAL KAMERA & LENSA (CRUD)
     * =========================================================================
     */
    public function indexRentalItems(): View
    {
        $cameras = RentalItem::where('category', 'camera')->orderBy('id', 'asc')->get();
        $lenses = RentalItem::where('category', 'lens')->orderBy('id', 'asc')->get();

        return view('admin.cms.rental-items', compact('cameras', 'lenses'));
    }

    public function storeRentalItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:camera,lens',
            'daily_price' => 'required|integer|min:0',
            'sensor_type' => 'nullable|string|max:255',
            'mount_type' => 'nullable|string|max:255',
            'requires_fe_lens' => 'nullable|boolean',
            'description' => 'nullable|string',
            'specs_text' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $specs = [];
        if (! empty($validated['specs_text'])) {
            $specs = array_values(array_filter(array_map('trim', explode("\n", $validated['specs_text']))));
        }

        $slug = Str::slug($validated['name']);
        if (RentalItem::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        RentalItem::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category' => $validated['category'],
            'daily_price' => (int) $validated['daily_price'],
            'sensor_type' => $validated['sensor_type'] ?? null,
            'mount_type' => $validated['mount_type'] ?? 'Sony E-Mount',
            'requires_fe_lens' => $request->boolean('requires_fe_lens'),
            'description' => $validated['description'] ?? null,
            'specifications' => $specs,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return back()->with('success', 'Unit sewa baru "'.$validated['name'].'" berhasil ditambahkan!');
    }

    public function updateRentalItem(Request $request, RentalItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:camera,lens',
            'daily_price' => 'required|integer|min:0',
            'sensor_type' => 'nullable|string|max:255',
            'mount_type' => 'nullable|string|max:255',
            'requires_fe_lens' => 'nullable|boolean',
            'description' => 'nullable|string',
            'specs_text' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $specs = [];
        if (! empty($validated['specs_text'])) {
            $specs = array_values(array_filter(array_map('trim', explode("\n", $validated['specs_text']))));
        }

        $item->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'daily_price' => (int) $validated['daily_price'],
            'sensor_type' => $validated['sensor_type'] ?? null,
            'mount_type' => $validated['mount_type'] ?? 'Sony E-Mount',
            'requires_fe_lens' => $request->boolean('requires_fe_lens'),
            'description' => $validated['description'] ?? null,
            'specifications' => $specs,
            'is_available' => $request->boolean('is_available'),
        ]);

        return back()->with('success', 'Unit sewa "'.$item->name.'" berhasil diperbarui!');
    }

    public function deleteRentalItem(RentalItem $item): RedirectResponse
    {
        $name = $item->name;
        $item->delete();

        return back()->with('success', 'Unit sewa "'.$name.'" berhasil dihapus dari katalog!');
    }

    public function toggleRentalItem(RentalItem $item): RedirectResponse
    {
        $item->update(['is_available' => ! $item->is_available]);

        return back()->with('success', 'Status ketersediaan unit "'.$item->name.'" berhasil diubah!');
    }

    /**
     * =========================================================================
     * 4. KELOLA PORTOFOLIO KARYA (CRUD)
     * =========================================================================
     */
    public function indexPortfolios(): View
    {
        $portfolios = PortfolioItem::orderBy('sort_order', 'asc')->get();

        return view('admin.cms.portfolio', compact('portfolios'));
    }

    public function storePortfolio(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'gear_used' => 'nullable|string|max:255',
            'brief' => 'nullable|string',
            'concept_3d' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']);
        if (PortfolioItem::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        PortfolioItem::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'client_name' => $validated['client_name'],
            'venue' => $validated['venue'] ?? null,
            'gear_used' => $validated['gear_used'] ?? null,
            'brief' => $validated['brief'] ?? null,
            'concept_3d' => $validated['concept_3d'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return back()->with('success', 'Item portofolio "'.$validated['title'].'" berhasil ditambahkan!');
    }

    public function updatePortfolio(Request $request, PortfolioItem $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'gear_used' => 'nullable|string|max:255',
            'brief' => 'nullable|string',
            'concept_3d' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $portfolio->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'client_name' => $validated['client_name'],
            'venue' => $validated['venue'] ?? null,
            'gear_used' => $validated['gear_used'] ?? null,
            'brief' => $validated['brief'] ?? null,
            'concept_3d' => $validated['concept_3d'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return back()->with('success', 'Portofolio "'.$portfolio->title.'" berhasil diperbarui!');
    }

    public function deletePortfolio(PortfolioItem $portfolio): RedirectResponse
    {
        $title = $portfolio->title;
        $portfolio->delete();

        return back()->with('success', 'Portofolio "'.$title.'" berhasil dihapus!');
    }

    /**
     * =========================================================================
     * 5. KELOLA FAQ PENGUNJUNG (CRUD)
     * =========================================================================
     */
    public function indexFaqs(): View
    {
        $faqs = FaqItem::orderBy('sort_order', 'asc')->get();

        return view('admin.cms.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        FaqItem::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'category' => $validated['category'] ?? 'Umum',
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Pertanyaan FAQ baru berhasil ditambahkan!');
    }

    public function updateFaq(Request $request, FaqItem $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'category' => $validated['category'] ?? 'Umum',
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function deleteFaq(FaqItem $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus!');
    }

    public function toggleFaq(FaqItem $faq): RedirectResponse
    {
        $faq->update(['is_active' => ! $faq->is_active]);

        return back()->with('success', 'Status FAQ diperbarui!');
    }
}
