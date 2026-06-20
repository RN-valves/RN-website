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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('auth_id');
            $table->string('created_by',100);
            $table->string('name',100);
            $table->string('url_key',155);
            $table->string('title',100);
            $table->string('keywords',155);
            $table->string('description',155);
            $table->string('short_description');
            $table->longText('content');
            $table->string('image');
            $table->string('status',25);
            $table->date('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
