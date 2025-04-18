<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->integer('months')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // FeatureFlags
            // $table->boolean('feature1')->defualt(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
