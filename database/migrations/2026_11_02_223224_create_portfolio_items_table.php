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
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // Corporate, Brand Activation, Gathering, Concert & Show, Wedding & Private
            $table->string('client_name');
            $table->date('event_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('gear_used')->nullable();
            $table->text('brief')->nullable();
            $table->text('concept_3d')->nullable();
            $table->text('execution_notes')->nullable();
            $table->unsignedInteger('audience_count')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
