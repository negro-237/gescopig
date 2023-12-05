<?php

namespace App\Repositories;

use App\Helpers\AcademicYear;
use App\Models\AcademicYear as AcademicYearModel;
use App\Models\Apprenant;
use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ApprenantRepository
 * @package App\Repositories
 * @version December 1, 2017, 10:57 pm UTC
 *
 * @method Apprenant findWithoutFail($id, $columns = ['*'])
 * @method Apprenant find($id, $columns = ['*'])
 * @method Apprenant first($columns = ['*'])
*/
class ApprenantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'tel',
        'specialite_id',
        'tel_parent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Apprenant::class;
    }

    public function store($request) {

        $apprenant = $this->create($this->getApprenantInput($request));
        $n = $request->input('number');
        for($i = 1; $i<=$n; $i++ ){
            Tutor::create([
                'name'  => $request->input('name'.$i),
                'profession' => $request->input('profession'.$i),
                'addresse' => $request->input('addresse'.$i),
                'tel_mobile' => $request->input('tel_mobile'.$i),
                'tel_bureau' => $request->input('tel_bureau'.$i),
                'tel_fixe' => $request->input('tel_fixe'.$i),
                'type' => $request->input('type'.$i),
                'apprenant_id' => $apprenant->id,
            ]);
        }
        return $apprenant;
    }

    private function getInputTutor($request, $apprenant){

//        $inputParent = $request->only('name', 'profession', 'addresse', 'tel_mobile', 'tel_bureau', 'tel_fixe', 'type');
//        return $inputParent;
    }

    private function getApprenantInput($request)
    {
        $inscrip = AcademicYearModel::find($request->input('academic_year_id'));
        $suffixe = $inscrip->apprenants()->withTrashed()->count() == 0 ? 1 : $inscrip->apprenants()->withTrashed()->count() + 133;
        $matricule = $inscrip->fin. 'PIG'. str_pad($suffixe,3,0,STR_PAD_LEFT);
        $inputApprenant = $request->only('nom', 'prenom', 'sexe', 'addresse', 'tel', 'phone', 'matricule', 'dateNaissance', 'lieuNaissance', 'nationalite', 'civilite', 'email', 'quartier', 'academic_year_id', 'etablissement_provenance', 'academic_mail', 'diplome', 'situation_professionnelle', 'region', 'entreprise', 'annee1',
        'etablissement1', 'ville1', 'classe1', 'diplome1', 'annee2', 'etablissement2', 'ville2', 
        'classe2', 'diplome2', 'annee3', 'etablissement3', 'ville3', 'classe3', 'diplome3', 'serie_baccalaureat', 'mention', 'annee_baccalaureat', 'autre_diplome', 'langue1',
        'classe_langue1', 'diplome_langue1', 'langue2', 'classe_langue2', 'diplome_langue2', 'langue3', 'classe_langue3', 'diplome_langue3', 'activites_associatives', 'annee_stage1',
        'etablissement_stage1', 'nature1', 'nom_adresse_entreprise1', 'annee_stage2',
        'etablissement_stage2', 'nature2', 'nom_adresse_entreprise2', 'annee_stage3',
        'etablissement_stage3', 'nature3', 'nom_adresse_entreprise3', 'q1',
        'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'r1', 'r2', 'r3');
        $inputApprenant['matricule'] = $matricule;
        $inputApprenant['academic_year_id'] = $inscrip->id;

        return $inputApprenant;
    }

    public function saveChanges($request, $apprenant){
        $tutor = $apprenant->tutor;
        $tutor->update($this->getInputTutor($request));
        $inputApprenant = $request->except('name', 'profession', 'addresse', 'tel_mobile', 'tel_bureau', 'tel_fixe', 'type');
        $apprenant->update($inputApprenant);
    }

    private function getVille($id_ville){
        $ville = [
            1 => 'DLA',
            2 => 'YDE',
            3 => 'MRA',
        ];

        return $ville[$id_ville];
    }
}
