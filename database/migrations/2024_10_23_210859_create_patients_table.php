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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index()->nullable();
            $table->string('puid')->index()->unique(); // Patient user id (puid)  is unique id string or QR for searching patient it will be added inside every print for the patient
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('clinic_id')->index();
            $table->unsignedTinyInteger('age');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedSmallInteger('nationality')->nullable();
            $table->string('address')->nullable();
            $table->text('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->text('family_medical_history')->nullable();
            $table->json('chronic_diseases')->nullable();
            $table->string('national_card_id')->nullable();
            $table->string('blood_type')->nullable();
            $table->unsignedTinyInteger('height')->nullable(); // BMI metrics
            // $table->unsignedSmallInteger('weight')->nullable(); // should be taken in the Evaluations it changes a lot.
            $table->string('marital_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('insurance_provider')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
