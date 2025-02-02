<?php

use App\Enums\Clinic\ClinicLevelEnum;
use App\Enums\Clinic\ClinicTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index()->nullable();
            $table->unsignedTinyInteger('level')->default(ClinicLevelEnum::DEFAULT); // عيادة رئيسية

            $table->string('code')->index()->unique();
            $table->string('name');
            $table->unsignedTinyInteger('type')->default(ClinicTypeEnum::DEFAULT);
            $table->string('status')->default('new');
            $table->unsignedBigInteger('plan_id');
            $table->string('location')->nullable();
            $table->timestamp('lease_expired_at')->nullable();
            $table->timestamp('lease_started_at')->nullable();

            // If the clinic is branch (when this is not null then it's clinic_branch and not main clinic)
            $table->unsignedBigInteger('sub_clinic_admin_id')->nullable()->index();
            $table->unsignedBigInteger('parent_clinic_id')->nullable();

            // Features
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
