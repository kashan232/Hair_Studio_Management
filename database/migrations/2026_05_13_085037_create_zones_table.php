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

        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Region / Zone Name');
            $table->string('job_title')->nullable();
            $table->string('full_name')->nullable();
            $table->string('cell_no')->nullable();
            $table->text('full_address')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
