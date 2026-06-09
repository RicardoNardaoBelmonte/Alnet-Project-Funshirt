<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            // code is the CSS color value (e.g. 'black', 'navy', '#7fffd4')
            // also used as the base t-shirt image filename in storage/app/public/tshirt_base/
            $table->string('code')->primary();
            $table->string('name');
            $table->text('custom')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};