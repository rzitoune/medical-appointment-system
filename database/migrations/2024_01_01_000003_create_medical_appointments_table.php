<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->constrained('medical_professionals')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('appointment_type', ['first_consultation', 'follow_up', 'emergency', 'teleconsultation', 'home_visit']);
            $table->string('consultation_reason');
            $table->text('symptoms')->nullable();
            $table->enum('urgency_level', ['low', 'medium', 'high'])->default('low');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->text('no_show_reason')->nullable();
            $table->timestamps();

            $table->index(['professional_id', 'appointment_date', 'start_time'], 'med_appt_prof_date_time_idx');
            $table->index(['patient_id', 'appointment_date'], 'med_appt_patient_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_appointments');
    }
};