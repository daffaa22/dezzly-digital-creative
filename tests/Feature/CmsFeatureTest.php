<?php

namespace Tests\Feature;

use App\Models\FaqItem;
use App\Models\Package;
use App\Models\RentalItem;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::first();
    }

    public function test_guest_cannot_access_cms_routes(): void
    {
        $this->get(route('admin.cms.settings'))->assertRedirect(route('login'));
        $this->get(route('admin.cms.packages'))->assertRedirect(route('login'));
        $this->get(route('admin.cms.rental-items'))->assertRedirect(route('login'));
        $this->get(route('admin.cms.portfolio'))->assertRedirect(route('login'));
        $this->get(route('admin.cms.faqs'))->assertRedirect(route('login'));
    }

    public function test_admin_can_view_all_cms_pages(): void
    {
        $this->actingAs($this->admin)->get(route('admin.cms.settings'))->assertStatus(200)->assertSee('Pengaturan Teks');
        $this->actingAs($this->admin)->get(route('admin.cms.packages'))->assertStatus(200)->assertSee('Kelola Paket Jasa Dokumentasi');
        $this->actingAs($this->admin)->get(route('admin.cms.rental-items'))->assertStatus(200)->assertSee('Kelola Katalog Kamera');
        $this->actingAs($this->admin)->get(route('admin.cms.portfolio'))->assertStatus(200)->assertSee('Kelola Portofolio');
        $this->actingAs($this->admin)->get(route('admin.cms.faqs'))->assertStatus(200)->assertSee('Kelola FAQ');
    }

    public function test_admin_can_update_site_settings_and_see_it_on_landing_page(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.cms.settings.update'), [
            'studio_name' => 'DEZZLY PRO STUDIO',
            'whatsapp_number' => '0821-9999-8888',
            'hero_headline_1' => 'Momen Sinematik Spektakuler.',
        ]);

        $response->assertRedirect();
        $this->assertEquals('DEZZLY PRO STUDIO', SiteSetting::get('studio_name'));
        $this->assertEquals('0821-9999-8888', SiteSetting::get('whatsapp_number'));
        $this->assertEquals('Momen Sinematik Spektakuler.', SiteSetting::get('hero_headline_1'));

        // Visit landing page and verify new texts appear
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('DEZZLY PRO STUDIO');
        $homeResponse->assertSee('0821-9999-8888');
        $homeResponse->assertSee('Momen Sinematik Spektakuler.');
    }

    public function test_admin_can_crud_package(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.cms.packages.store'), [
            'name' => 'Paket Ultra Cinema 8K',
            'subtitle' => 'Paket Bioskop Tertinggi',
            'base_gear' => 'Sony FX3 Cinema Line',
            'crew_fg_count' => 2,
            'crew_vg_count' => 3,
            'has_drone' => true,
            'turnaround_days' => 7,
            'photo_output' => '100 Edited Photos',
            'video_output' => '8K Master File + Reels',
            'features_text' => "Lensa Cine T1.5\nDrone FPV Balap\nAudio Wireless Tentacle",
            'is_popular' => true,
            'is_active' => true,
        ]);
        $response->assertRedirect();

        $package = Package::where('name', 'Paket Ultra Cinema 8K')->first();
        $this->assertNotNull($package);
        $this->assertTrue($package->has_drone);
        $this->assertCount(3, $package->features);

        // 2. Update
        $this->actingAs($this->admin)->put(route('admin.cms.packages.update', $package), [
            'name' => 'Paket Ultra Cinema 8K Rev',
            'subtitle' => 'Paket Bioskop Diperbarui',
            'base_gear' => 'Sony FX3 Cinema Line',
            'crew_fg_count' => 3,
            'crew_vg_count' => 3,
            'has_drone' => false,
            'turnaround_days' => 5,
            'photo_output' => '100 Edited Photos',
            'video_output' => '8K Master File + Reels',
            'features_text' => 'Fitur Baru 1',
            'is_popular' => false,
            'is_active' => true,
        ])->assertRedirect();

        $package->refresh();
        $this->assertEquals('Paket Ultra Cinema 8K Rev', $package->name);
        $this->assertFalse($package->has_drone);

        // 3. Toggle
        $this->actingAs($this->admin)->patch(route('admin.cms.packages.toggle', $package))->assertRedirect();
        $package->refresh();
        $this->assertFalse($package->is_active);

        // 4. Delete
        $this->actingAs($this->admin)->delete(route('admin.cms.packages.delete', $package))->assertRedirect();
        $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    }

    public function test_admin_can_crud_rental_item(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.cms.rental-items.store'), [
            'name' => 'Sony FX30 Cinema',
            'category' => 'camera',
            'daily_price' => 200000,
            'sensor_type' => 'Super 35 Exmor R CMOS',
            'mount_type' => 'Sony E-Mount',
            'specs_text' => "Dual Base ISO\nActive Cooling Fan\n10-bit 4:2:2 DCI 4K",
            'is_available' => true,
        ]);
        $response->assertRedirect();

        $item = RentalItem::where('name', 'Sony FX30 Cinema')->first();
        $this->assertNotNull($item);
        $this->assertEquals(200000, $item->daily_price);

        // 2. Toggle availability
        $this->actingAs($this->admin)->patch(route('admin.cms.rental-items.toggle', $item))->assertRedirect();
        $item->refresh();
        $this->assertFalse($item->is_available);

        // 3. Delete
        $this->actingAs($this->admin)->delete(route('admin.cms.rental-items.delete', $item))->assertRedirect();
        $this->assertDatabaseMissing('rental_items', ['id' => $item->id]);
    }

    public function test_admin_can_crud_faq(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.cms.faqs.store'), [
            'question' => 'Apakah ada promo diskon sewa di hari biasa?',
            'answer' => 'Ada! Dapatkan potongan khusus untuk sewa kamera minimal 3 hari berturut-turut pada hari kerja (Senin-Kamis).',
            'category' => 'Sewa Kamera',
            'sort_order' => 10,
            'is_active' => true,
        ]);
        $response->assertRedirect();

        $faq = FaqItem::where('question', 'Apakah ada promo diskon sewa di hari biasa?')->first();
        $this->assertNotNull($faq);

        // Verify it displays on the visitor landing page
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Apakah ada promo diskon sewa di hari biasa?');

        // 2. Toggle active
        $this->actingAs($this->admin)->patch(route('admin.cms.faqs.toggle', $faq))->assertRedirect();
        $faq->refresh();
        $this->assertFalse($faq->is_active);

        // 3. Delete
        $this->actingAs($this->admin)->delete(route('admin.cms.faqs.delete', $faq))->assertRedirect();
        $this->assertDatabaseMissing('faq_items', ['id' => $faq->id]);
    }
}
