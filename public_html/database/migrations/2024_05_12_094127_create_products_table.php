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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('subcategory_id');
            $table->unsignedInteger('content_id')->nullable();
            $table->string('brand', 25);
            $table->string('material', 35);
            $table->string('color_name', 55);
            $table->string('color_icon')->nullable();
            $table->string('name', 155);
            $table->string('color_group_id', 155);
            $table->string('product_combo_id', 155);
            $table->string('product_size_id', 155);
            $table->string('uuid', 155)->unique();
            $table->string('url_key',155)->unique();
            $table->string('article', 15);
            $table->string('sku_code', 15);
            $table->string('size', 25);
            $table->string('hsn', 25);
            $table->string('image');
            $table->float('in_mrp');
            $table->float('in_selling');
            $table->float('in_v1_mrp')->default(0);
            $table->float('oth_mrp');
            $table->float('oth_selling');
            $table->float('oth_v1_mrp')->default(0);
            $table->string('title',100);
            $table->string('keywords',155);
            $table->string('description',155);
            $table->string('search_keywords');
            $table->string('status',25)->default('Active');
            $table->tinyInteger('is_visible_website')->default(1);
            $table->tinyInteger('is_visible_api')->default(1);
            $table->tinyInteger('new_arrival')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_isicertified')->default(0);
            $table->string('sale_type',35);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
