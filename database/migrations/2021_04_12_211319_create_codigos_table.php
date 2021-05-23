<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('products_id');
            $table->double('precio');
            $table->double('precio_unitario');
            $table->double('ganancia');
            $table->integer('porcentaje');
            $table->integer('cantidad');
            $table->double('total');
            //$table->date('fecha_pago')->nullable();
            $table->string('codigo');
            $table->string('estatus_credito')->nullable();
            //$table->integer('stock')->default(0);
            //$table->string('nombre_cliente')->nullable();
            //$table->string('autorizado');
            $table->foreign('products_id')->references('id')->on('products');
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
        Schema::dropIfExists('codigos');
    }
}
