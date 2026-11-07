<?php

namespace Tests\Feature;

use App\Models\RentalItem;
use App\Models\RentalOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalOrderValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_rental_item_must_be_a_camera(): void
    {
        $lens = RentalItem::where('category', 'lens')->firstOrFail();

        $this->postJson('/rental/order', $this->payload(['rental_item_id' => $lens->id]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('rental_item_id');
    }

    public function test_rental_item_must_be_available(): void
    {
        $camera = RentalItem::where('category', 'camera')->firstOrFail();
        $camera->update(['is_available' => false]);

        $this->postJson('/rental/order', $this->payload(['rental_item_id' => $camera->id]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('rental_item_id');
    }

    public function test_lens_item_must_be_a_lens(): void
    {
        $camera = RentalItem::where('category', 'camera')->firstOrFail();

        $this->postJson('/rental/order', $this->payload([
            'rental_item_id' => $camera->id,
            'lens_item_id' => $camera->id,
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('lens_item_id');
    }

    public function test_full_frame_camera_requires_fe_lens(): void
    {
        $camera = RentalItem::where('requires_fe_lens', true)->firstOrFail();

        $this->postJson('/rental/order', $this->payload(['rental_item_id' => $camera->id]))
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_overlapping_confirmed_order_is_rejected(): void
    {
        $camera = RentalItem::where('name', 'Sony A6000')->firstOrFail();
        $startDate = now()->addDays(3)->startOfDay();

        RentalOrder::create([
            'order_code' => 'DZY-RENT-TEST01',
            'customer_name' => 'Existing Customer',
            'customer_whatsapp' => '081200000000',
            'rental_item_id' => $camera->id,
            'start_date' => $startDate->toDateString(),
            'duration_days' => 2,
            'total_price' => 200000,
            'status' => 'confirmed',
        ]);

        $this->postJson('/rental/order', $this->payload([
            'rental_item_id' => $camera->id,
            'start_date' => $startDate->copy()->addDay()->toDateString(),
            'duration_days' => 2,
        ]))
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_valid_booking_with_lens_returns_whatsapp_url(): void
    {
        $camera = RentalItem::where('name', 'Sony A7III')->firstOrFail();
        $lens = RentalItem::where('category', 'lens')->where('sensor_type', 'Full Frame')->firstOrFail();

        $this->postJson('/rental/order', $this->payload([
            'rental_item_id' => $camera->id,
            'lens_item_id' => $lens->id,
        ]))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'order_code', 'total_price_formatted', 'whatsapp_url']);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Budi Santoso',
            'customer_whatsapp' => '081234567890',
            'rental_item_id' => RentalItem::where('name', 'Sony A6000')->value('id'),
            'start_date' => now()->addDays(2)->toDateString(),
            'duration_days' => 2,
        ], $overrides);
    }
}
