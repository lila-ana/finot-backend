<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->uuid('class_id')->primary();
            $table->string('class_name'); // Name of the class
            $table->text('description')->nullable(); // Description of the class
            $table->unsignedInteger('max_capacity')->nullable(); // Maximum capacity of the class
            // $table->enum('class_type', ['youth', 'adult', 'children', 'bible_study'])->default('adult'); // Type of class
            $table->string('class_type')->nullable(); // Type of class
            $table->string('schedule')->nullable(); // Schedule of the class (e.g., weekly, bi-weekly)
            $table->string('location')->nullable(); // Physical location of the class
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
