<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewChurchGoodsTable extends Migration
{
    public function up(): void
    {
        Schema::create('church_goods', function (Blueprint $table) {
            $table->uuid('church_goods_id')->primary(); // Use UUID for the primary key
            $table->string('name'); // Name of the church good
            $table->text('description')->nullable(); // Description
            $table->integer('quantity'); // Quantity available
            $table->decimal('price', 8, 2); // Price per unit
            $table->uuid('categories_id'); // Foreign key for category

            // Correct the foreign key constraint reference
            $table->foreign('categories_id')->references('categories_id')->on('categories')->onDelete('cascade'); // Foreign key constraint

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_goods');
    }
}

