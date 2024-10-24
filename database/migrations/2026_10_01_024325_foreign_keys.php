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
        #-----------------------------clinics--------------------------------#
        Schema::table('clinics', function(Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans')->cascadeOnDelete();
        });
        #-----------------------------doctors--------------------------------#
        Schema::table('clinic_admins', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('clinic_id')->references('id')->on('clinics')->cascadeOnDelete();
        });

        #-----------------------------doctors--------------------------------#
        Schema::table('doctors', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('clinic_id')->references('id')->on('clinics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        #-----------------------------clinics--------------------------------#
        Schema::table('clinics', function(Blueprint $table){
            // $table->dropForeign(['clinic_admin_id']);
            $table->dropForeign(['plan_id']);
        });

        #-----------------------------clinics--------------------------------#
        Schema::table('clinic_admins', function(Blueprint $table){
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['user_id']);
        });

        #-----------------------------doctors--------------------------------#
        Schema::table('doctors', function(Blueprint $table){
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
