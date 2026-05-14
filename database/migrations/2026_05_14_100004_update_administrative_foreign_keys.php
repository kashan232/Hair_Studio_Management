<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('circles')) {
            Schema::table('circles', function (Blueprint $table) {
                if (Schema::hasColumn('circles', 'zone_id')) {
                    $table->renameColumn('zone_id', 'region_id');
                }
            });
        }

        if (Schema::hasTable('sub_divisions')) {
            Schema::table('sub_divisions', function (Blueprint $table) {
                if (Schema::hasColumn('sub_divisions', 'division_id')) {
                    $table->renameColumn('division_id', 'irrigation_division_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sub_divisions')) {
            Schema::table('sub_divisions', function (Blueprint $table) {
                if (Schema::hasColumn('sub_divisions', 'irrigation_division_id')) {
                    $table->renameColumn('irrigation_division_id', 'division_id');
                }
            });
        }

        if (Schema::hasTable('circles')) {
            Schema::table('circles', function (Blueprint $table) {
                if (Schema::hasColumn('circles', 'region_id')) {
                    $table->renameColumn('region_id', 'zone_id');
                }
            });
        }
    }
};
