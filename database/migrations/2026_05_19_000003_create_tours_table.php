<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('duration')->nullable(); // e.g. "5 Days / 4 Nights"
            $table->decimal('price_per_person', 10, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->integer('max_persons')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
