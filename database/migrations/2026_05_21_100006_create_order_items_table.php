<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('tshirt_image_id')->constrained('tshirt_images')->cascadeOnDelete();
            $table->string('color_code');
            $table->foreign('color_code')->references('code')->on('colors');
            $table->string('size'); // XS, S, M, L, XL
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2); // snapshot of price at checkout
            $table->decimal('sub_total', 10, 2);   // qty * unit_price
            $table->text('custom')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};