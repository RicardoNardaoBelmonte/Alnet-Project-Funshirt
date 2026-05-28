<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tshirts', function (Blueprint $table) {
            $table->unsignedInteger('sales_count')->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('tshirts', function (Blueprint $table) {
            $table->dropColumn('sales_count');
        });
    }
};