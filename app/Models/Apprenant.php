<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Notifications\Notifiable;

/**
 * Class Apprenant
 * @package App\Models
 * @version December 1, 2017, 10:57 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection absenceApprenants
 * @property \App\Models\Specialite specialite
 * @property string name
 * @property string tel
 * @property integer specialite_id
 * @property string tel_parent
 */
class Apprenant extends Model
{
    use SoftDeletes;
    //use RevisionableTrait;
    use Notifiable;

    //protected $revisionCreationsEnabled = true;
    //protected $revisionForceDeleteEnabled = true;

    public $table = 'apprenants';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        // 1- Informations de la migration create_apprenants_table
        'nom',
        'prenom',
        'sexe',
        
        'tel',
        'phone',
        'email',
        'nationalite',
        'dateNaissance',
        'lieuNaissance',
        'region',

        'matricule',
        'civilite',
        'quartier',
        'academic_year_id',

        // 2- Informations de la migration update_apprenants_table
        'academic_mail',
        'diplome',
        'addresse',
        'situation_professionnelle',
        'etablissement_provenance',

        // 3- Informations de la migration add_apprenant_informations
        'entreprise',      
        // Scolarité (les 3 dernières années)
        'annee1',
        'etablissement1',
        'ville1',
        'classe1',
        'diplome1',

        'annee2',
        'etablissement2',
        'ville2',
        'classe2',
        'diplome2',

        'annee3',
        'etablissement3',
        'ville3',
        'classe3',
        'diplome3',

        'serie_baccalaureat',
        'mention',
        'annee_baccalaureat',
        'autre_diplome',

        // Langues étrangères
        'langue1',
        'classe_langue1',
        'diplome_langue1',

        'langue2',
        'classe_langue2',
        'diplome_langue2',

        'langue3',
        'classe_langue3',
        'diplome_langue3',

        // Activités associatives ou sportives
        'activites_associatives',

        // Stages et expériences professionnelles
        'annee_stage1',
        'etablissement_stage1',
        'nature1',
        'nom_adresse_entreprise1',

        'annee_stage2',
        'etablissement_stage2',
        'nature2',
        'nom_adresse_entreprise2',

        'annee_stage3',
        'etablissement_stage3',
        'nature3',
        'nom_adresse_entreprise3',

        // Questionnaire
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'q6',
        'q7',

        // Observation(s) de l'administration de l'école
        'r1',
        'r2',
        'r3',

        // Données de la fiche médicale de l'apprenant
        'nom_hopital',
        'adresse_hopital',
        'telephone_hopital',

        'nom_medecin',
        'adresse_medecin',
        'telephone_medecin',

        'diabete',
        'asthme',
        'affection_cardiaque',
        'affcection_cutanée',
        'handicap_moteur',
        'autres',
        'precision_autres',
        'frequence_autres',
        'question_allergies',
        'question_regime_alimentaire',
        'question_traitement_medical',
        'question_vaccin_covid',
        'statut_electrophorese',
        'groupe_sanguin',
        'rhesus',

        'remarques_eventuelles'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nom' => 'bail|required|max:250',
        'prenom' => 'bail|required|max:250',
        'sexe' => 'bail|required|max:25',
        'addresse' => 'bail|required',

        'tel' => 'bail|required',
        'email' => 'bail|required|email',
        'nationalite' => 'bail|required',
        'dateNaissance' => 'date',
        'lieuNaissance' => 'bail|required',
        'region' => 'bail|required',
        'situation_professionnelle' => 'bail|required',
        'entreprise',


        'matricule' => 'bail|required',
        'civilite' => 'bail|required',
        'quartier' => 'bail|required',

        'etablissement_provenance' => 'bail|required',
        'academic_mail',
        'diplome' => 'bail|required',

        'name' => 'bail|required',
        'profession' => 'bail|required',
        'tel_mobile' => 'bail|required',
        'tel_bureau' => 'bail',
        'tel_fixe' => 'bail',
        'type' => 'bail|required',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nom' => 'bail|required|max:250',
        'prenom' => 'bail|required|max:250',
        'sexe' => 'bail|required|max:25',
        
        'tel' => 'bail|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        'phone' => 'bail|nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        'email' => 'bail|required|email',
        'nationalite' => 'bail|required',
        'dateNaissance' => 'bail|required',
        'lieuNaissance' => 'bail|required',
        'region' => 'bail|required',

        'matricule',
        'civilite' => 'bail|required',
        'quartier' => 'bail|required',
        'academic_year_id' => 'bail|required',

        'academic_mail',
        'diplome' => 'bail|required',
        'addresse' => 'bail|required',
        'situation_professionnelle' => 'bail|required',
        'etablissement_provenance' => 'bail|required',

        'entreprise',      
        // Ici toutes les autres informations de add_apprenant_information       

        'name1' => 'bail|required',
        'profession1' => 'bail|required',
        'addresse1' => 'bail|required',
        'tel_mobile1' => 'bail|required',
        'tel_bureau' => 'bail',
        'tel_fixe' => 'bail',
        'type1' => 'bail|required',
        
        'specialite_id' => 'bail|required',
        'cycle_id' => 'bail|required',
        'ville_id' => 'bail|required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
//    public function absences()
//    {
//        return $this->hasMany(\App\Models\Absence::class);
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function specialite()
//    {
//        return $this->belongsTo(\App\Models\Specialite::class);
//    }
//
//    public function cycle(){
//        return $this->belongsTo(Cycle::class);
//    }

    public function tutors(){
        return $this->hasMany(Tutor::class);
    }

    public function medical_exams(){
        return $this->hasMany(MedicalExam::class);
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function contrats(){
        return $this->hasMany(Contrat::class);
    }

    public function scolarites(){
        return $this->hasMany(Scolarite::class);
    }

    public function semestre_infos(){
        return $this->hasManyThrough(SemestreInfo::class, Contrat::class);
    }

    public function country() {
        return $this->belongsTo(Pays::class, 'nationalite');
    }
}
