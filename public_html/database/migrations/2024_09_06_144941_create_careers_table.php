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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('created_id')->default(0);
            $table->string('created_by',100);
            $table->string('uuid',155);
            $table->string('edit_by',100);
            $table->string('title');
            $table->string('designation');
            $table->string('attachment')->nullable();
            $table->string('zipcode',8);
            $table->string('city',100);
            $table->string('state',100);
            $table->string('country',100);
            $table->date('published_at');
            $table->longText('content');
            $table->string('status',25)->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areers');
    }
};
