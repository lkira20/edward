<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cantidad');
            $table->double('total');

            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('codigos_id');

            $table->foreign('codigos_id')->references('id')->on('codigos');
            $table->foreign('venta_id')->references('id')->on('inversions');

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
        Schema::dropIfExists('detalle_ventas');
    }
}
