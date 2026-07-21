<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('stripe_payment_intent')->nullable()->after('total_amount');
            $table->string('refund_status')->nullable()->after('stripe_payment_intent');
            $table->decimal('refunded_amount', 10, 2)->nullable()->after('refund_status');
            $table->timestamp('refunded_at')->nullable()->after('refunded_amount');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_payment_intent',
                'refund_status',
                'refunded_amount',
                'refunded_at',
            ]);
        });
    }
};
