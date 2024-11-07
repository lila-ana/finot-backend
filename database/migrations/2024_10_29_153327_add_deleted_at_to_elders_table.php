<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToEldersTable extends Migration
{
    public function up()
    {
        Schema::table('elders', function (Blueprint $table) {
            $table->softDeletes(); // Adds `deleted_at` column
        });
    }

    public function down()
    {
        Schema::table('elders', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Drops `deleted_at` column
        });
    }
}

