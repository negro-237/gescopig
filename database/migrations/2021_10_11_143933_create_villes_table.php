<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('villes');
        Schema::disableForeignKeyConstraints();
        Schema::create('villes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('code');
            $table->integer('pays_id')->unsigned();
            $table->foreign('pays_id')->references('id')->on('pays')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villes');
    }
}
