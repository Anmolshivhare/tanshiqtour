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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->date('travel_date')->nullable()->after('tour_id');
            $table->unsignedInteger('adults')->default(1)->after('travel_date');
            $table->unsignedInteger('children')->default(0)->after('adults');
            $table->string('city')->nullable()->after('children');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn([
                'travel_date',
                'adults',
                'children',
                'city',
            ]);
        });
    }
};
