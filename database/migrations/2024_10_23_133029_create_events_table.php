<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->string('event_name')->unique();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('event_type')->nullable();
            $table->integer('capacity')->nullable();;
            $table->string('organizer_name')->nullable();;
            $table->string('contact_info')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
