<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('articulo_id');
            $table->string('name');
            $table->decimal('quanty');
            $table->string('unit_type_mayor');
            $table->string('unit_type_menor');
            $table->integer('qty_per_unit');
            $table->string('status')->default('2');
            $table->integer('total_qty_prod');
            
            $table->timestamps();
            //$table->foreign('articulo_id')->references('id')->on('articulos');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}
