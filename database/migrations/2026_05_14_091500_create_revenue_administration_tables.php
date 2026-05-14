<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revenue_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revenue_division_id')->constrained('revenue_divisions')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('talukas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('revenue_circles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taluka_id')->constrained('talukas')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('tappas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revenue_circle_id')->constrained('revenue_circles')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('dehs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tappa_id')->constrained('tappas')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deh_id')->constrained('dehs')->onDelete('cascade');
            $table->string('number'); // The survey number itself
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_numbers');
        Schema::dropIfExists('dehs');
        Schema::dropIfExists('tappas');
        Schema::dropIfExists('revenue_circles');
        Schema::dropIfExists('talukas');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('revenue_divisions');
    }
};
