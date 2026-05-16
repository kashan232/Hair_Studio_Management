<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_canals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_canal_id')->constrained('sub_canals')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['sub_canal_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_canals');
    }
};
