<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinic_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index()->nullable();

            $table->unsignedBigInteger('user_id')->index()->unique();
            // $table->unsignedBigInteger('clinic_id')->index();
            $table->string('type')->default('admin'); // super_admin, admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_admins');
    }
};
