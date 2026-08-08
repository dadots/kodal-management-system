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
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Identity
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('legal_name')->nullable();

            // Contact
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Branding
            $table->string('logo_path')->nullable();

            // Regional settings
            $table->string('timezone')->default('Asia/Manila');
            $table->string('currency', 3)->default('PHP');
            $table->string('locale', 10)->default('en');

            // Platform state
            $table->string('status')->default('active');

            // Tenant-specific configuration
            $table->json('settings')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
