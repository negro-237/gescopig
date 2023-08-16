<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprenantInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apprenants', function (Blueprint $table) {
            $table->string('entreprise')->nullable();

            // 1- Données de la fiche de candidature de l'apprenant
            
            // Scolarité (les 3 dernières années)
            $table->string('annee1')->nullable();
            $table->string('etablissement1')->nullable();
            $table->string('ville1')->nullable();
            $table->string('classe1')->nullable();
            $table->string('diplome1')->nullable();

            $table->string('annee2')->nullable();
            $table->string('etablissement2')->nullable();
            $table->string('ville2')->nullable();
            $table->string('classe2')->nullable();
            $table->string('diplome2')->nullable();

            $table->string('annee3')->nullable();
            $table->string('etablissement3')->nullable();
            $table->string('ville3')->nullable();
            $table->string('classe3')->nullable();
            $table->string('diplome3')->nullable();

            $table->string('serie_baccalaureat')->nullable();
            $table->string('mention')->nullable();
            $table->string('annee_baccalaureat')->nullable();
            $table->string('autre_diplome')->nullable();

            // Langues étrangères
            $table->string('langue1')->nullable();
            $table->string('classe_langue1')->nullable();
            $table->string('diplome_langue1')->nullable();

            $table->string('langue2')->nullable();
            $table->string('classe_langue2')->nullable();
            $table->string('diplome_langue2')->nullable();

            $table->string('langue3')->nullable();
            $table->string('classe_langue3')->nullable();
            $table->string('diplome_langue3')->nullable();

            // Activités associatives ou sportives
            $table->text('activites_associatives')->nullable();

            // Stages et expériences professionnelles
            $table->string('annee_stage1')->nullable();
            $table->string('etablissement_stage1')->nullable();
            $table->string('nature1')->nullable();
            $table->string('nom_adresse_entreprise1')->nullable();

            $table->string('annee_stage2')->nullable();
            $table->string('etablissement_stage2')->nullable();
            $table->string('nature2')->nullable();
            $table->string('nom_adresse_entreprise2')->nullable();

            $table->string('annee_stage3')->nullable();
            $table->string('etablissement_stage3')->nullable();
            $table->string('nature3')->nullable();
            $table->string('nom_adresse_entreprise3')->nullable();

            // Questionnaire
            $table->text('q1')->nullable();
            $table->text('q2')->nullable();
            $table->text('q3')->nullable();
            $table->text('q4')->nullable();
            $table->text('q5')->nullable();
            $table->text('q6')->nullable();
            $table->text('q7')->nullable();

            // Observation(s) de l'administration de l'école
            $table->text('r1')->nullable();
            $table->text('r2')->nullable();
            $table->text('r3')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apprenants', function (Blueprint $table) {
            //
        });
    }
}
