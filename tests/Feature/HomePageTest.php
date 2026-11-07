<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\RentalItem;
use App\Models\User;
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
        $response->assertSee('Dokumentasi');
        $response->assertSee('Paket Menengah');
        $response->assertSee('Rental Gear Studio');
        $response->assertSee('Sony A6000');
    }

    /**
     * Test that admin dashboard requires authentication and loads when logged in.
     */
    public function test_admin_dashboard_requires_authentication(): void
    {
        // Unauthenticated request should redirect to login
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        // Authenticated admin should be able to view dashboard
        $user = User::first();
        $authResponse = $this->actingAs($user)->get('/admin');
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Dashboard Operasional Dezzly');
    }

    /**
     * Test admin login functionality.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@dezzlycreative.com',
            'password' => 'dezzly123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
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

    /**
     * Test the exact payload sent by the landing page inquiry forms.
     */
    public function test_service_inquiry_from_landing_page_returns_whatsapp_url(): void
    {
        $response = $this->postJson('/service/inquiry', [
            'package_id' => null,
            'service_type' => 'Konsultasi Dokumentasi',
            'customer_name' => 'Rian Anggara',
            'customer_whatsapp' => '08123456789',
            'company_name' => '',
            'event_date' => '',
            'venue_location' => '',
            'brief_notes' => 'Butuh dokumentasi acara kampus.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure(['success', 'inquiry_code', 'whatsapp_url']);
        $this->assertStringContainsString('wa.me', $response->json('whatsapp_url'));
    }

    /**
     * Test that inquiry fails validation when the service type is missing.
     */
    public function test_service_inquiry_requires_service_type(): void
    {
        $response = $this->postJson('/service/inquiry', [
            'customer_name' => 'Rian Anggara',
            'customer_whatsapp' => '08123456789',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('service_type');
    }
}
