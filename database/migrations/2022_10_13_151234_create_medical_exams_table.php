<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_exams', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('date_examen')->nullable();
            $table->text('signes_symptomes')->nullable();
            $table->text('premiers_soins')->nullable();
            $table->text('avis_infirmier')->nullable();
            $table->integer('apprenant_id')->unsigned();

            $table->timestamps();
            $table->foreign('apprenant_id')->references('id')->on('apprenants')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_exams');
    }
}
