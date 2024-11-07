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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Primary key as an auto-incrementing integer
            $table->uuid('tokenable_id'); // UUID for the tokenable ID
            $table->string('tokenable_type'); // Type of the tokenable model
            $table->string('name'); // Name of the token
            $table->string('token', 64)->unique(); // Unique token
            $table->text('abilities')->nullable(); // Nullable abilities field
            $table->timestamp('last_used_at')->nullable(); // Last usage
            $table->timestamp('expires_at')->nullable(); // Expiration date
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens'); // Drop the table on rollback
    }
};
