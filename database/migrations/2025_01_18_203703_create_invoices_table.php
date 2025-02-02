<?php

use App\Enums\Invoice\InvoiceStatusEnum;
use App\Enums\Invoice\InvoiceTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->unsignedTinyInteger('type')->default(InvoiceTypeEnum::PATIENT_APPOINTMENT->value)->index();
            $table->unsignedBigInteger('organization_id')->index();
            $table->unsignedBigInteger('clinic_id')->index()->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('paid_price', 10, 2)->default(0);
            $table->json('content')->nullable();
            $table->unsignedTinyInteger('status')->default(InvoiceStatusEnum::PENDING->value)->index();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
