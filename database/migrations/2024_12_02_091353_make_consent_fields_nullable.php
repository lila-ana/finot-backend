<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('data_protection_consent')->nullable()->change();
            $table->boolean('media_release_consent')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('data_protection_consent')->nullable(false)->change();
            $table->boolean('media_release_consent')->nullable(false)->change();
        });
    }
};
