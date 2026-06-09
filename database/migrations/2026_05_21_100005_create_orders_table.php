<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending'); // pending, closed, canceled
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('date');
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
            $table->text('reason_for_cancellation')->nullable();
            $table->string('nif');
            $table->text('address');
            $table->string('payment_type'); // Visa, PayPal, MB WAY
            $table->string('payment_ref');
            $table->string('receipt_url')->nullable(); // generated when status → closed
            $table->text('custom')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};