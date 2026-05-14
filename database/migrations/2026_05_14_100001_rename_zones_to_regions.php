<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('zones')) {
            Schema::rename('zones', 'regions');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('regions')) {
            Schema::rename('regions', 'zones');
        }
    }
};
