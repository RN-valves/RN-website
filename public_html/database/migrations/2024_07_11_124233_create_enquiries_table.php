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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pincode_id')->default(0);
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('state_id')->default(0);
            $table->unsignedInteger('country_id')->default(0);
            $table->unsignedInteger('salesmen_id')->default(0);
            $table->string('name',55);
            $table->string('uuid',155);
            $table->string('ip_address',70);
            $table->string('company_name',55);
            $table->string('mobile',12);
            $table->string('zipcode',6);
            $table->string('email',100)->nullable();
            $table->string('enquiry_type',25)->default('Customer');
            $table->string('scource_type',15)->default('Website');
            $table->string('address',255)->nullable();
            $table->string('purpose',255);
            $table->string('published_at',50);
            $table->string('created_by',55)->default('Admin');
            $table->string('page_url',255)->nullable();
            $table->string('status',25)->default("Pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
