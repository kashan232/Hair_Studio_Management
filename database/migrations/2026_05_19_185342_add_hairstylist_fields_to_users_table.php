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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('hairstylist')->after('password');
            $table->string('specialization')->nullable()->after('designation');
            $table->integer('experience_years')->nullable()->after('specialization');
            $table->string('instagram_handle')->nullable()->after('experience_years');
            $table->text('bio')->nullable()->after('instagram_handle');
            $table->string('avatar')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'specialization',
                'experience_years',
                'instagram_handle',
                'bio',
                'avatar'
            ]);
        });
    }
};
