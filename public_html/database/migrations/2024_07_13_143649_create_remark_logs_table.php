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
        Schema::create('remark_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('logable');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('user_name',65);
            $table->string('customer_name',100);
            $table->string('customer_mobile',12);
            $table->string('remark',100);
            $table->string('message',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remark_logs');
    }
};
