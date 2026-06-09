<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tshirt_images', function (Blueprint $table) {
            $table->id();
            // null = catalogue image; set = private customer image
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            // null = no category; only catalogue images can have a category
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url');
            $table->text('custom')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tshirt_images');
    }
};