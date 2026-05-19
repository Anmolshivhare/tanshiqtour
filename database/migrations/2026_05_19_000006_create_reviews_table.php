<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->tinyInteger('rating')->default(5); // 1-5
            $table->string('review_title')->nullable();
            $table->text('review_body');
            $table->unsignedBigInteger('status')->nullable(); // pending/approved/rejected
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
