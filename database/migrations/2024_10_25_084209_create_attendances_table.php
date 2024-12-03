<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('attendance_id')->primary();
            $table->uuid('elder_id'); // Foreign key for elder
            $table->uuid('class_id'); // Foreign key for class
            $table->uuid('member_id');
            $table->boolean('attended')->default(false); // Flag for attendance
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('elder_id')->references('elder_id')->on('elders')->onDelete('cascade');
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
