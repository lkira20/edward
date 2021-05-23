<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInversionIdCodigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('codigos', function (Blueprint $table) {

            $table->unsignedBigInteger('inversion_id')->nullable();

            $table->foreign('inversion_id')->references('id')->on('inversions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('codigos', function (Blueprint $table) {
            $table->dropForeign(['inversion_id']);
        });
    }
}
