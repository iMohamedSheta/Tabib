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
        // Only User Authentication Information
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index()->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();

            $table->string('password')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('role');  // e.g., 'doctor', 'clinic_admin', etc.
            $table->unsignedBigInteger('role_id')->nullable();  // Foreign key to the role-specific table

            $table->timestamp('last_connect')->useCurrent(); // Login || Logout

            $table->string('phone')->nullable();
            $table->string('other_phone')->nullable();

            //Features
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            //OAuth2
            $table->string('oauth_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->text('oauth_token')->nullable();
            $table->integer('oauth_token_expires_in')->nullable();
            $table->json('oauth_scopes')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
