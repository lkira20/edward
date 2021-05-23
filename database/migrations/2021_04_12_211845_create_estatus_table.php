<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estatus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo');
            $table->string('cantidad');
            $table->string('cliente')->nullable();
            $table->unsignedBigInteger('codigos_id');
            $table->foreign('codigos_id')->references('id')->on('codigos');
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
        Schema::dropIfExists('estatus');
    }
}
