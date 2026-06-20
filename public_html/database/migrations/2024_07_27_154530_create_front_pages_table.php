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
        Schema::create('front_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name',35);
            $table->string('title',100);
            $table->string('keywords',200);
            $table->string('description',155);
            $table->string('logo',155);
            $table->string('mobile',15);
            $table->string('email',100);
            $table->string('address')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('insta_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('pinterest_link')->nullable();
            $table->string('goole_app_link')->nullable();
            $table->string('ios_app_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('front_pages');
    }
};
