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
        Schema::table('user_levels', function (Blueprint $table) {
            $table->integer('step')->default(1);
        });
    }

    public function down()
    {
        Schema::table('user_levels', function (Blueprint $table) {
            $table->dropColumn('step');
        });
    }
};
