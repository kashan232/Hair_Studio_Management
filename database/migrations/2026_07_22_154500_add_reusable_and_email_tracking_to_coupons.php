<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'is_reusable')) {
                $table->boolean('is_reusable')->default(false)->after('is_active');
            }
        });

        if (!Schema::hasColumn('coupon_user', 'email')) {
            Schema::table('coupon_user', function (Blueprint $table) {
                $table->string('email')->nullable()->after('user_id');
                $table->index('email');
            });
        }

        // Allow guest redemptions without a user account
        try {
            Schema::table('coupon_user', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        } catch (\Throwable $e) {
            // Foreign key name may differ across environments
        }

        DB::statement('ALTER TABLE coupon_user MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('coupon_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        try {
            Schema::table('coupon_user', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        } catch (\Throwable $e) {
            // ignore
        }

        if (Schema::hasColumn('coupon_user', 'email')) {
            Schema::table('coupon_user', function (Blueprint $table) {
                $table->dropIndex(['email']);
                $table->dropColumn('email');
            });
        }

        DB::statement('ALTER TABLE coupon_user MODIFY user_id BIGINT UNSIGNED NOT NULL');

        Schema::table('coupon_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        if (Schema::hasColumn('coupons', 'is_reusable')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('is_reusable');
            });
        }
    }
};
