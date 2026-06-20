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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->string('name',100);
            $table->string('mobile',15);
            $table->string('email',100);
            $table->string('state',55);
            $table->string('city',35);
            $table->string('zipcode',8);
            $table->string('payment_gateway',30)->default('Razorpay');
            $table->string('payment_key');
            $table->string('payment_secret_key');
            $table->string('payment_id');
            $table->string('status',55);
            $table->text('payment_data');
            $table->float('amount',0,12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
