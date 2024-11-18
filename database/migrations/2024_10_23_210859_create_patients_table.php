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

            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('clinic_id')->index();
            $table->unsignedTinyInteger('age');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedSmallInteger('nationality')->nullable();
            $table->string('address')->nullable();
            $table->text('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->string('national_card_id')->nullable();
            $table->unsignedTinyInteger('height')->nullable();
            $table->unsignedSmallInteger('weight')->nullable();
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
