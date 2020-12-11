<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInterviewDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview', function (Blueprint $table) {
            $table->bigInteger('other_phone')->change();
            $table->bigInteger('phone')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview', function (Blueprint $table) {
            //
        });
    }
}
