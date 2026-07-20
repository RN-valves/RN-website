<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->unsignedInteger('display_order')->default(0)->after('id')->index();
        });

        // Auto-populate display_order for all existing subcategories (baseline = their id)
        DB::statement('UPDATE subcategories SET display_order = id');

        // Set the desired PTMT collection order by name
        $order = [
            'Virtu Pine Collection'   => 1,
            'Lagoon Pine Collection'  => 2,
            'Lagoon Regal Collection' => 3,
            'Virtu Regal Collection'  => 4,
            'G20 Pine Collection'     => 5,
            'G20 Regal Collection'    => 6,
            'M-Series Collection'     => 7,
            'Glamour Pro Collection'  => 8,
            'Glamour Collection'      => 9,
            'Lofty Collection'        => 10,
            'Tiara Collection'        => 11,
            'Alpha Pro Collection'    => 12,
            'Prestine Collection'     => 13,
            'Aroma Collection'        => 14,
            'Lagoon Collection'       => 15,
            'Jaldhara Collection'     => 16,
            'Felicity Collection'     => 17,
            'Della Collection'        => 18,
            'Virtu Pro Collection'    => 19,
            'Virtu Collection'        => 20,
            'Supernova Collection'    => 21,
            'Saffron Collection'      => 22,
            'PTMT Diverter Spouts'    => 23,
            'PTMT Diverter'           => 24,
            'Majestic Collection'     => 25,
            'G20 Pro Collection'      => 26,
            'G20 Collection'          => 27,
            'Elegance Collection'     => 28,
            'Ani-Pro Collection'      => 29,
        ];

        foreach ($order as $name => $displayOrder) {
            DB::table('subcategories')
                ->where('name', $name)
                ->update(['display_order' => $displayOrder]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropIndex(['display_order']);
            $table->dropColumn('display_order');
        });
    }
};
