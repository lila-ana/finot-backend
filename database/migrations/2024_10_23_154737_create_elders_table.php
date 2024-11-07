<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elders', function (Blueprint $table) {
            $table->uuid('elder_id')->primary();
            $table->string('name'); // Name of the elder
            $table->string('contact_info')->nullable(); // Contact information
            $table->string('email')->unique()->nullable(); // Email address
            $table->string('phone')->nullable(); // Phone number
            $table->string('address')->nullable(); // Address
            $table->string('position')->nullable(); // Position or title within the church
            $table->text('bio')->nullable(); // Brief biography
            $table->string('unique_identifier')->unique();
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
        Schema::dropIfExists('elders');
    }
}
