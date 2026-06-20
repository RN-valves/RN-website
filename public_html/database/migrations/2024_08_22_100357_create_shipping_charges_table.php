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
        Schema::create('shipping_charges', function (Blueprint $table) {
            $table->id();
            $table->float('w_0_100gm',0,8)->default(0);
            $table->float('w_101_200gm',0,8)->default(0);
            $table->float('w_201_400gm',0,8)->default(0);
            $table->float('w_401_600gm',0,8)->default(0);
            $table->float('w_601_1000gm',0,8)->default(0);
            $table->float('w_1001_1500gm',0,8)->default(0);
            $table->float('w_1501_2000gm',0,8)->default(0);
            $table->float('w_2001_2500gm',0,8)->default(0);
            $table->float('w_2501_3000gm',0,8)->default(0);
            $table->float('w_3001_4000gm',0,8)->default(0);
            $table->float('w_4001_5000gm',0,8)->default(0);
            $table->float('w_5001_10000gm',0,8)->default(0);
            $table->float('w_10001_20000gm',0,8)->default(0);
            $table->float('w_20001_40000gm',0,8)->default(0);
            $table->string('status',25)->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_charges');
    }
};
