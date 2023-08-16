<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprenantMedicalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apprenants', function (Blueprint $table) {
            // Add columns 
            // 2- Données de la fiche médicale de l'apprenant

            // Hôpital ou clinique souhaité
            $table->string('nom_hopital')->nullable()->after('r3');
            $table->string('adresse_hopital')->nullable();
            $table->string('telephone_hopital')->nullable();

            // Médecin traitant
            $table->string('nom_medecin')->nullable();
            $table->string('adresse_medecin')->nullable();
            $table->string('telephone_medecin')->nullable();

            // Information médicales confidentielles
            $table->boolean('diabete')->default(false);
            $table->boolean('asthme')->default(false);
            $table->boolean('affection_cardiaque')->default(false);
            $table->boolean('affcection_cutanée')->default(false);
            $table->boolean('handicap_moteur')->default(false);
            $table->boolean('autres')->default(false);
            $table->text('precision_autres')->nullable();
            $table->text('frequence_autres')->nullable();
            $table->text('question_allergies')->nullable();
            $table->text('question_regime_alimentaire')->nullable();
            $table->text('question_traitement_medical')->nullable();
            $table->text('question_vaccin_covid')->nullable();
            $table->string('statut_electrophorese')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->string('rhesus')->nullable();

            // Remarques éventuelles
            $table->text('remarques_eventuelles')->nullable();
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
