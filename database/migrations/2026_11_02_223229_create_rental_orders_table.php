<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->string('customer_email')->nullable();
            $table->foreignId('rental_item_id')->constrained('rental_items')->cascadeOnDelete();
            $table->foreignId('lens_item_id')->nullable()->constrained('rental_items')->nullOnDelete();
            $table->date('start_date');
            $table->unsignedSmallInteger('duration_days')->default(1);
            $table->unsignedInteger('total_price');
            $table->string('status')->default('pending'); // pending, confirmed, active, returned, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_orders');
    }
};
