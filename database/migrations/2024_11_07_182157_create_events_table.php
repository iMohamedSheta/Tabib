<?php

use App\Enums\Calendar\CalendarTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index();
            $table->unsignedTinyInteger('type')->default(CalendarTypeEnum::DEFAULT);
            $table->string('title');
            $table->timestamp('start_at')->index();
            $table->timestamp('end_at')->index()->nullable();
            $table->boolean('all_day')->default(false);
            $table->json('data');
            $table->unsignedBigInteger('clinic_id')->index()->nullable();
            $table->unsignedBigInteger('doctor_id')->index()->nullable();
            $table->unsignedBigInteger('patient_id')->index()->nullable();
            $table->unsignedBigInteger('clinic_service_id')->index()->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
