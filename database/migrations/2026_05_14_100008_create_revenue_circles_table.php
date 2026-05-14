<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('revenue_circles')) {
            Schema::create('revenue_circles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('taluka_id')->constrained('talukas')->onDelete('cascade');
                $table->string('name');
                $table->string('code')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('revenue_circles');
    }
};
