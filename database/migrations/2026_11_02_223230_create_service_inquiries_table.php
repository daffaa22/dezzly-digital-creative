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
        Schema::create('service_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_code')->unique();
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->string('customer_email')->nullable();
            $table->string('company_name')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('service_type'); // Paket Dokumentasi, Custom Multicam / Live Streaming, Full EO Production
            $table->date('event_date')->nullable();
            $table->string('venue_location')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->text('brief_notes')->nullable();
            $table->string('status')->default('new'); // new, contacted, quoted, deal, lost
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_inquiries');
    }
};
