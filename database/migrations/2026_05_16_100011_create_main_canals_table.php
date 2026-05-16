<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_canals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barrage_id')->constrained('barrages')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['barrage_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_canals');
    }
};
