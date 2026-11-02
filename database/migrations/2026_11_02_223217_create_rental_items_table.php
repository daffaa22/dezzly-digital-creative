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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // camera, lens, accessory
            $table->string('sensor_type')->nullable(); // APS-C, Full Frame
            $table->string('mount_type')->nullable(); // E-Mount, FE-Mount
            $table->unsignedInteger('daily_price'); // IDR per 24 hours
            $table->boolean('requires_fe_lens')->default(false); // A7 series requirement
            $table->text('description')->nullable();
            $table->json('specifications')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
