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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('member_id')->primary(); 
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('address');
            $table->string('phone_number');
            $table->string('email_address')->unique();
            $table->date('date_of_baptism')->nullable();
            $table->enum('membership_status', ['active', 'inactive']);
            $table->string('previous_church_affiliation')->nullable();
            $table->text('family_members')->nullable(); // Store as JSON or a serialized array
            $table->text('children_info')->nullable(); // Store as JSON or a serialized array
            $table->text('areas_of_interest')->nullable(); // Store as JSON or a serialized array
            $table->text('spiritual_gifts')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_relation');
            $table->string('emergency_contact_phone');
            $table->string('profile_picture')->nullable();
            $table->text('notes_comments')->nullable();
            $table->boolean('data_protection_consent')->default(false)->nullable();
            $table->boolean('media_release_consent')->default(false)->nullable();
            $table->string('profession_detail')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('unique_identifier')->unique();
            $table->string('elder_id')->nullable()->index();  // Adjust data type if necessary
            $table->string('class_id')->nullable()->index(); 
            $table->timestamps();
            $table->softDeletes();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
