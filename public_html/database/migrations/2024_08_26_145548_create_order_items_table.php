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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->string('product_code',20);
            $table->string('cart_id',155);
            $table->string('product_color',55);
            $table->string('product_size',55);
            $table->float('price',0,8);
            $table->float('product_lbh_weight_gm');
            $table->integer('total_qty');
            $table->float('total_amount',0,12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
