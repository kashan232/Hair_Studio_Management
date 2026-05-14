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
        // Rename zones to regions
        if (Schema::hasTable('zones')) {
            Schema::rename('zones', 'regions');
        }

        // Add unit_id to regions
        if (Schema::hasTable('regions')) {
            Schema::table('regions', function (Blueprint $table) {
                if (!Schema::hasColumn('regions', 'unit_id')) {
                    $table->unsignedBigInteger('unit_id')->after('id')->nullable();
                    $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
                }
            });
        }

        // Rename divisions to irrigation_divisions
        if (Schema::hasTable('divisions')) {
            Schema::rename('divisions', 'irrigation_divisions');
        }

        // Update foreign keys in circles (points to regions now)
        if (Schema::hasTable('circles')) {
            Schema::table('circles', function (Blueprint $table) {
                if (Schema::hasColumn('circles', 'zone_id')) {
                    $table->renameColumn('zone_id', 'region_id');
                }
            });
        }

        // Update foreign keys in sub_divisions (points to irrigation_divisions now)
        if (Schema::hasTable('sub_divisions')) {
            Schema::table('sub_divisions', function (Blueprint $table) {
                if (Schema::hasColumn('sub_divisions', 'division_id')) {
                    $table->renameColumn('division_id', 'irrigation_division_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert sub_divisions
        if (Schema::hasTable('sub_divisions')) {
            Schema::table('sub_divisions', function (Blueprint $table) {
                if (Schema::hasColumn('sub_divisions', 'irrigation_division_id')) {
                    $table->renameColumn('irrigation_division_id', 'division_id');
                }
            });
        }

        // Revert circles
        if (Schema::hasTable('circles')) {
            Schema::table('circles', function (Blueprint $table) {
                if (Schema::hasColumn('circles', 'region_id')) {
                    $table->renameColumn('region_id', 'zone_id');
                }
            });
        }

        // Rename irrigation_divisions back to divisions
        if (Schema::hasTable('irrigation_divisions')) {
            Schema::rename('irrigation_divisions', 'divisions');
        }

        // Revert regions
        if (Schema::hasTable('regions')) {
            Schema::table('regions', function (Blueprint $table) {
                if (Schema::hasColumn('regions', 'unit_id')) {
                    $table->dropForeign(['unit_id']);
                    $table->dropColumn('unit_id');
                }
            });
            Schema::rename('regions', 'zones');
        }
    }
};
