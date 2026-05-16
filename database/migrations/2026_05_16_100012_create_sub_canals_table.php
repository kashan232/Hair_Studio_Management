<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_canals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_canal_id')->constrained('main_canals')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['main_canal_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_canals');
    }
};
