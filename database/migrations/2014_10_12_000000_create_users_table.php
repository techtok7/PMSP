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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password')->nullable()->default(null);
            $table->boolean('is_verified')->default(false);
            $table->string('otp', 6)->nullable();
            $table->integer('minimum_minutes')->default(30);
            $table->integer('maximum_minutes')->default(60);
            $table->string('google_id')->nullable();
            $table->string('google_access_token')->nullable();
            $table->string('google_refresh_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
