<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\RentalItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test that homepage loads successfully with seeded items.
     */
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('DEZZLY');
        $response->assertSee('Sony A6000');
        $response->assertSee('Paket Menengah');
    }

    /**
     * Test that admin dashboard loads successfully.
     */
    public function test_admin_dashboard_loads_successfully(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Operasional Dezzly');
    }

    /**
     * Test creating a camera rental order.
     */
    public function test_can_create_rental_order(): void
    {
        $camera = RentalItem::where('name', 'Sony A6000')->first();

        $response = $this->postJson('/rental/order', [
            'customer_name' => 'Budi Santoso',
            'customer_whatsapp' => '081234567890',
            'rental_item_id' => $camera->id,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'duration_days' => 2,
            'notes' => 'Testing rental booking',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('rental_orders', [
            'customer_name' => 'Budi Santoso',
            'rental_item_id' => $camera->id,
            'duration_days' => 2,
        ]);
    }

    /**
     * Test creating a service inquiry.
     */
    public function test_can_create_service_inquiry(): void
    {
        $package = Package::where('name', 'Paket Menengah')->first();

        $response = $this->postJson('/service/inquiry', [
            'customer_name' => 'Corporate HR Mandiri',
            'customer_whatsapp' => '081299998888',
            'package_id' => $package->id,
            'service_type' => $package->name,
            'event_date' => now()->addMonth()->format('Y-m-d'),
            'venue_location' => 'Jakarta Convention Center',
            'brief_notes' => 'Annual company gathering 500 pax',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('service_inquiries', [
            'customer_name' => 'Corporate HR Mandiri',
            'package_id' => $package->id,
        ]);
    }
}
