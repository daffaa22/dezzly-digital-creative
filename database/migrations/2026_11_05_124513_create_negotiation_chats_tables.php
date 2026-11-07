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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_code', 32)->unique();
            $table->string('session_token', 64)->unique()->index();
            $table->string('customer_name', 120);
            $table->string('customer_whatsapp', 50)->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('package_name', 150)->nullable();
            $table->text('initial_notes')->nullable();
            $table->decimal('agreed_price', 14, 2)->nullable();
            $table->date('event_date')->nullable();
            $table->string('venue_location', 200)->nullable();
            $table->text('deal_notes')->nullable();
            $table->timestamp('deal_at')->nullable()->index();
            $table->string('status', 30)->default('active')->index(); // 'active', 'deal', 'archived'
            $table->unsignedInteger('admin_unread_count')->default(0);
            $table->unsignedInteger('customer_unread_count')->default(0);
            $table->timestamp('last_message_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained('chat_sessions')->cascadeOnDelete();
            $table->string('sender_type', 20); // 'customer', 'admin', 'system'
            $table->string('sender_name', 120);
            $table->text('message');
            $table->boolean('is_deal_card')->default(false);
            $table->json('deal_payload')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['chat_session_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};
