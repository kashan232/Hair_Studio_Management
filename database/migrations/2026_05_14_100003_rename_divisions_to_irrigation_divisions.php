<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('divisions')) {
            Schema::rename('divisions', 'irrigation_divisions');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('irrigation_divisions')) {
            Schema::rename('irrigation_divisions', 'divisions');
        }
    }
};
