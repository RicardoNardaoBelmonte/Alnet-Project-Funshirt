<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tshirt_color', function (Blueprint $table) {
            $table->foreignId('tshirt_id')->constrained('tshirts')->cascadeOnDelete();
            $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();
            $table->primary(['tshirt_id', 'color_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tshirt_color');
    }
};
