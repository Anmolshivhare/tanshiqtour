<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This will add the 'status' column as a foreign key 
     * in the 'users' table after the 'address' field.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('status')->after('address')->constrained('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This will drop the 'status' foreign key and column if rolled back.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['status']);
            $table->dropColumn('status');
        });
    }
};
