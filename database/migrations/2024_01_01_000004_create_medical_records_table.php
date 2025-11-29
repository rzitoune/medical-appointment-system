<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained('medical_appointments')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->constrained('medical_professionals')->onDelete('cascade');
            $table->text('diagnosis')->nullable(); // Encrypted
            $table->text('treatment_plan')->nullable(); // Encrypted
            $table->text('notes')->nullable(); // Encrypted
            $table->json('vital_signs')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->timestamps();

            $table->index(['patient_id', 'created_at']);
            $table->index(['professional_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
