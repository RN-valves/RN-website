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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('content_id')->nullable();
            $table->integer('discount');
            $table->integer('tax');
            $table->string('name',55);
            $table->string('uuid',155)->unique();
            $table->string('url_key',155)->unique();
            $table->string('title',100);
            $table->string('keywords',150);
            $table->string('description',150);
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->tinyInteger('is_visible_website')->default(1);
            $table->string('status',25)->default('Active');
            $table->string('pdf_catalogue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
