<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('regions')) {
            Schema::table('regions', function (Blueprint $table) {
                if (!Schema::hasColumn('regions', 'unit_id')) {
                    $table->unsignedBigInteger('unit_id')->after('id')->nullable();
                    $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('regions')) {
            Schema::table('regions', function (Blueprint $table) {
                if (Schema::hasColumn('regions', 'unit_id')) {
                    $table->dropForeign(['unit_id']);
                    $table->dropColumn('unit_id');
                }
            });
        }
    }
};
