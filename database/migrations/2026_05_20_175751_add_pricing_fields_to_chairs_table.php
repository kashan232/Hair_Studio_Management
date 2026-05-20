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
        Schema::table('chairs', function (Blueprint $table) {
            $table->decimal('price_hourly', 10, 2)->nullable()->after('status');
            $table->decimal('price_daily', 10, 2)->nullable()->after('price_hourly');
            $table->decimal('price_monthly', 10, 2)->nullable()->after('price_daily');
            $table->decimal('price_yearly', 10, 2)->nullable()->after('price_monthly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chairs', function (Blueprint $table) {
            $table->dropColumn(['price_hourly', 'price_daily', 'price_monthly', 'price_yearly']);
        });
    }
};
