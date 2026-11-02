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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->unsignedInteger('price_daily')->default(0); // 0 = custom inquiry
            $table->string('base_gear');
            $table->unsignedTinyInteger('crew_fg_count')->default(1);
            $table->unsignedTinyInteger('crew_vg_count')->default(1);
            $table->boolean('has_drone')->default(false);
            $table->unsignedSmallInteger('turnaround_days')->default(5);
            $table->string('photo_output');
            $table->string('video_output');
            $table->json('features')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
