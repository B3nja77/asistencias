<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('alumnos', function (Blueprint $table) {
            $table->engine="InnoDB";
            
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('DNI');

            $table->bigInteger('grado_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->timestamps();

            $table->foreign('grado_id')->references('id')->on('grados')->onDelete("cascade");
            $table->foreign('seccion_id')->references('id')->on('secciones')->onDelete("cascade");
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
    }
};
