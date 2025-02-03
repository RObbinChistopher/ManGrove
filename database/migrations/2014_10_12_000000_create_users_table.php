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
            $table->string('email')->unique();
            $table->string('agent_id', 6)->unique(); // Add unique 6-digit column
            $table->enum('role', ['Admin', 'Manager', 'Employer'])->default('Employer');
            $table->string('phone');
            $table->string('profile')->nullable();
            $table->string('cnic')->nullable();
            $table->string('driving_licence')->nullable();
            $table->string('property_documents')->nullable();
            $table->timestamp(column: 'email_verified_at')->nullable();
            $table->string('password')->nullable();
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
