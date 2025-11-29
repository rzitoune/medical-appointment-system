<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('emergency_contact')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('allergies')->nullable(); // Encrypted
            $table->text('medical_history')->nullable(); // Encrypted
            $table->string('insurance_number')->nullable();
            $table->string('mutual_fund')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};