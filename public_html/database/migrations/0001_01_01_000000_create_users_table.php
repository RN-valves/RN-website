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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('pincode_id');
            $table->unsignedInteger('sales_user_id')->default(0);
            $table->string('user_type',25)->default('Employee');
            $table->string('name',100);
            $table->string('uuid',155);
            $table->string('user_code',25)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('mobile',15)->unique();
            $table->string('zipcode',6);
            $table->string('address');
            $table->string('profession',55)->default('Consumer');
            $table->string('gst_number',55)->nullable();
            $table->string('created_by',55)->default('Admin');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('status',25)->default('Active');
            $table->string('password');
            $table->string('local_password');
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
