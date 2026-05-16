<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_canal_id')->constrained('branch_canals')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['branch_canal_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributaries');
    }
};
