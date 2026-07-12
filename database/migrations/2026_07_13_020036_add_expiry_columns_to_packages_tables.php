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
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('expiry_days')->nullable()->after('is_active');
        });

        Schema::table('user_packages', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('expiry_days');
        });

        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};
