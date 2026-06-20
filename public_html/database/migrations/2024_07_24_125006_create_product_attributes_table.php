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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->string('sku_code',25)->unique();
            $table->integer('ctn_pcs');
            $table->integer('mid_ctn_pcs')->default(0);
            $table->integer('inner_pcs');
            $table->float('stock_pcs',8)->default(0);
            $table->float('moq',8)->default(1);
            $table->float('only_product_wt_gm',8)->default(0);
            $table->float('product_length',8)->default(0);
            $table->float('product_breadth',8)->default(0);
            $table->float('product_height',8)->default(0);
            $table->float('product_lbh_weight_gm',8)->default(0);
            $table->float('mid_ctn_lbh_weight_kg',8)->default(0);
            $table->float('master_ctn_lbh_weight_kg',8)->default(0);
            $table->float('residential_warranty',8)->default(0);
            $table->float('commercial_warranty',8)->default(0);
            $table->string('amazon_link')->nullable();
            $table->string('flipkart_link')->nullable();
            $table->string('short_description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('created_by',55)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
