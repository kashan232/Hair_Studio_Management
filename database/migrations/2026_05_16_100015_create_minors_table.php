<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('minors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributary_id')->constrained('distributaries')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['distributary_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('minors');
    }
};
