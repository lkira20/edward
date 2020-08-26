<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('costo');
            $table->integer('iva_porc_menor');
            $table->integer('iva_menor');
            $table->decimal('sub_total_menor', 10, 2);
            $table->decimal('total_menor', 10, 2);
            $table->integer('iva_porc_mayor');
            $table->integer('iva_mayor');
            $table->decimal('sub_total_mayor', 10, 2);
            $table->decimal('total_mayor', 10, 2);
            $table->boolean('oferta')->default(0);
            $table->unsignedBigInteger('inventario_id');
            $table->timestamps();

            $table->foreign('inventario_id')->references('id')->on('inventarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precios');
    }
}
