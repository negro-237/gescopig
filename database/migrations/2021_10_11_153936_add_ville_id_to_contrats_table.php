<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVilleIdToContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrats', function (Blueprint $table) {
            // 1. Create new column
            $table->integer('ville_id')->unsigned()->nullable()->after('apprenant_id');
            // 2. Create foreign key constraints
            $table->foreign('ville_id')->references('id')->on('villes')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrats', function (Blueprint $table) {
            // 1. Drop foreign key constraints
            $table->dropForeign(['ville_id']);

            // 2. Drop the column
            $table->dropColumn('ville_id');
        });
    }
}
