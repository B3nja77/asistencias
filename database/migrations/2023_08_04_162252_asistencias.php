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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->bigInteger('alumno_id')->unsigned();
            $table->bigInteger('grado_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->date('fecha');
            $table->time('hora');

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->timestamps();
    
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete("cascade");
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
