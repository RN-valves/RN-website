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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shipping_charge_id');
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('pincode_id')->default(0);
            $table->string('name',100);
            $table->string('uuid',155);
            $table->string('company_name',100)->nullable();
            $table->string('mobile',13);
            $table->string('email');
            $table->string('country',25);
            $table->string('state',25);
            $table->string('city',25);
            $table->string('zipcode',6);
            $table->string('booking_address');
            $table->string('note')->nullable();
            $table->string('discount_code',155)->nullable();
            $table->float('discount_amount',0,12)->default(0);
            $table->float('shipping_amount',0,8)->default(0);
            $table->float('total_amount',0,12)->default(0);
            $table->string('status',25)->default('Pending');
            $table->string('is_payment',25)->nullable();
            $table->string('payment_key',155)->nullable();
            $table->string('payment_term',35)->nullable();
            $table->text('payment_data')->nullable();
            $table->bigInteger('carrier_id')->default(0);
            $table->string('courier_name')->nullable();
            $table->double('delivery_charge')->default(0);
            $table->double('cod_charge')->default(0);
            $table->double('rto_charge')->default(0);
            $table->double('gst_charge')->default(0);
            $table->double('total_delivery_charge')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
