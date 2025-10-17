<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicYear as Inscrip;
use App\Helpers\CodeUeHelper as SpeciialityCode;
use App\Http\Requests\CreateNoteRequest;
use App\Models\AcademicYear;
use App\Models\Contrat;
use App\Models\Apprenant;
use App\Models\Enseignement;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ContratRepository;
use App\Repositories\CycleRepository;
use App\Repositories\EcueRepository;
use App\Repositories\EnseignementRepository;
use App\Repositories\NoteRepository;
use App\Repositories\ResultatNominatifRepository;
use App\Repositories\SemestreInfoRepository;
use App\Repositories\SemestreRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\UeInfoRepository;
use App\Repositories\VilleRepository;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use DB;

class NoteController extends Controller
{
    protected $specialiteRepository;
    protected $cycleRepository;
    protected $semestreRepository;
    protected $enseignementRepository;
    protected $anneeAcademic;
    protected $contratRepository;
    protected $noteRepository;
    protected $ecueRepository;
    protected $ueInfoRepository;
    protected $semestreInfoRepository;
    protected $resultatNominatifsRepository;
    protected $specialityCode;
    protected $academicYearRepository;
    protected $villeRepository;

    public function __construct(CycleRepository $cycleRepository, SpecialiteRepository $specialiteRepository,
                                SemestreRepository $semestreRepository, EnseignementRepository $enseignementRepository,
                                ContratRepository $contratRepository, Inscrip $academicYear,
                                NoteRepository $noteRepository, EcueRepository $ecueRepository, UeInfoRepository $ueInfoRepository,
                                SemestreInfoRepository $semestreInfoRepository, ResultatNominatifRepository $resultatNominatifRepository,
                                AcademicYearRepository $academicYearRepository, VilleRepository $villeRepository)
    {
        $this->middleware(['role:Admin|AA|SG|SG2|AA2|CDFPCD']);
        $this->cycleRepository = $cycleRepository;
        $this->specialiteRepository = $specialiteRepository;
        $this->semestreRepository = $semestreRepository;
        $this->enseignementRepository = $enseignementRepository;
        $this->anneeAcademic = AcademicYear::find($academicYear->getCurrentAcademicYear());

        $this->contratRepository = $contratRepository;
        $this->noteRepository = $noteRepository;
        $this->ecueRepository = $ecueRepository;
        $this->semestreInfoRepository = $semestreInfoRepository;
        $this->ueInfoRepository = $ueInfoRepository;
        $this->resultatNominatifsRepository = $resultatNominatifRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->villeRepository = $villeRepository;

        $this->specialityCode = [
            'BF' => 1,
            'CG' => 2,
            'CMD' => 5,
            'TL' => 4,
            'IAIE' => 7,
            'MAMES' => 1,
            'MACMAD' => 2,
            'MAMREH' => 3,
            'MAACO' => 4,
            'MAFINE' => 5,
            'MAQUAP' => 6,
            'MATRAS' => 7,
            'MAFIDA' => 8,
            'EMBA' => 8,
            'NM' => 3,
            'MSD' => 6,
            'MIAIE' => 9
        ];
    }

    public function search($n, $type = null, $ville_id = null) {
        
        $specialites = $this->specialiteRepository->all();
        $cycles = $this->cycleRepository->all();
        $academicYears = [];
        $ay = $this->academicYearRepository->all();
        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }
        $cur_year= $this->anneeAcademic;

        if($n == '2') 
            $method = 'imprime';
        elseif($n == '1')
            $method = 'affiche';
        elseif($n == '3')
            $method = 'deliberation';
        elseif($n == '4')
            $method = 'rattrapage';
        /* elseif($n == '41')
            $method ='rattrapageDLA';
        elseif($n == '42')
            $method ='rattrapageYDE'; */
        elseif ($n == '5') {
            $method = 'pv';
        }
        elseif ($n == '6') {
            $method = 'pvcc';
        }
        elseif ($n == '7') {
            $method = 'rn_intermediaire';
        }
        elseif ($n== '8') {
            $method = 'fiche';
        }
       /* elseif($n == '9'){
            $method = 'ficheYaounde';
        }*/
        elseif($n == '10') {
            $method = 'afficheNotes';
        }
        /*elseif($n == '11'){
            $method = 'afficheNotesYaounde';
        }
        
        elseif($n == '12'){
            $method = 'deliberationDouala';
        }
        elseif($n == '13'){
            $method = 'deliberationYaounde';
        }
        
        elseif($n == '14'){
            $method = 'rn_intermediaireDouala';
        }
         elseif($n == '15'){
            $method = 'rn_intermediaireYaounde';
        }
         elseif ($n == '16'){
            $method = 'pvcc_dla';
        }
        elseif ($n == '17'){
            $method = 'pvcc_yde';
        } */
        $model = 'notes';

        return view('search', compact('cycles','model', 'method', 'type', 'academicYears', 'cur_year', 'ville_id'));
    }

    // Afficher tous les enseignements d'une spécialité donnée pour la ville de Douala
    public function fiche($semestre, $specialite, $ville_id) {

        //$ville = $this->villeRepository->findWithoutFail($ville_id);
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->anneeAcademic->id)->where('specialite_id', $specialite)->where('ville_id', $ville_id);
        
        return view('notes.fiche', compact('ec', 'semestre', 'specialite', 'ens', 'ville_id'));
    }

    // Afficher la liste des apprenants pour une année académique, un cycle, une spécialité pour la ville de Douala
    public function ficheNotationCC($semestre, $specialite, $id, $ville_id) {
        
        $ville = $this->villeRepository->findWithoutFail($ville_id);
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        //$cycle = $this->semestreRepository->find($semestre)->cycle;
        /*
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->anneeAcademic->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id]);
        */

        if($ville_id == 3) {
            if($semestre == 1 || $semestre == 2) $cycle = 10;
            else if($semestre == 3 || $semestre == 4) $cycle = 11;
            else if($semestre == 5 || $semestre == 6) $cycle = 12;
            else if($semestre == 7 || $semestre == 8) $cycle = 13;
            else $cycle = 14;
        } else {
            $cycle = $this->semestreRepository->find($semestre)->cycle->id;
        }

        $filter1 = $this->anneeAcademic->id;
        $filter2 = $cycle;
        $filter3 = $specialites->id;

        $apprenants = Apprenant::with(['contrats' => function($query) use ($filter1, $filter2, $filter3, $ville_id){
            $query->where('academic_year_id', $filter1)
            ->where('cycle_id', $filter2)
            ->where('specialite_id', $filter3)
            ->where('ville_id', $ville_id)
            ->where(
                function($query) {
                    return $query
                    ->where('inscription_status', '=', 'Inscrit')
                    ->orWhere('inscription_status', '=', 'Inscrit avec moratoire');
                }
            );
        }])->orderBy('nom', 'ASC')->get();

        $enseignement = $this->enseignementRepository->findWithoutFail($id);

        return view('notes.fiche-cc', compact('enseignement', 'apprenants', 'ville'));
    }

    // Afficher tous les enseignements d'une spécialité donnée pour la ville de Yaoundé
    public function ficheYaounde($semestre, $specialite){
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->anneeAcademic->id)->where('specialite_id', $specialite)->where('ville_id', 1);
        
        return view('notes.fiche-yaounde', compact('ec', 'semestre', 'specialite', 'ens'));
    }
    // Afficher la liste des apprenants pour une année académique, un cycle, une spécialité pour la ville de Yaoundé
    public function ficheNotationCCYaounde($semestre, $specialite, $id){
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $cycle = $this->semestreRepository->find($semestre)->cycle;
        /*
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->anneeAcademic->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id]);
        */

        $filter1 = $this->anneeAcademic->id;
        $filter2 = $cycle->id;
        $filter3 = $specialites->id;
        $filter4 = 2;

        $apprenants = Apprenant::with(['contrats' => function($query) use ($filter1, $filter2, $filter3, $filter4){
            $query->where('academic_year_id', $filter1)
            ->where('cycle_id', $filter2)
            ->where('specialite_id', $filter3)
            ->where('ville_id', $filter4)
            ->where(
                function($query) {
                    return $query
                    ->where('inscription_status', '=', 'Inscrit')
                    ->orWhere('inscription_status', '=', 'Inscrit avec moratoire');
                }
            );
        }])->orderBy('nom', 'ASC')->get();

        $enseignement = $this->enseignementRepository->findWithoutFail($id);

        return view('notes.fiche-cc-yaounde', compact('enseignement', 'apprenants'));
    }

    /**
     * @param $sem for semester
     * @param $spe for speciality
     * cette fonction sert à l'enregistrement des notes de l'etudiant
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function affiche($sem, $spe, Request $request) {

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id);

        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $ens = [];
        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->where('academic_year_id', '==', $aa->id)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        
        }
        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);

        return view('notes.affiche', compact('enseignements', 'specialite', 'semestre'));
    }

    // Afficher tous les ecues pour une spécialité et un semestre donné
    public function afficheNotes($sem, $spe, $ville_id, Request $request) {

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id);
        $ville = $this->villeRepository->findWithoutFail($ville_id);
        
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        $ens = [];

        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->where('ville_id', $ville_id)->where('academic_year_id', '==', $aa->id)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        }

        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);
        return view('notes.afficheNotes', compact('enseignements', 'specialite', 'semestre', 'ville'));
    }

    // Afficher tous les ecues pour une spécialité et un semestre donné de la ville de Yaoundé
    public function afficheNotesYaounde($sem, $spe, Request $request){
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        $ens = [];
        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->where('ville_id', 1)->where('academic_year_id', '==', $aa->id)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        }
        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);
        return view('notes.afficheNotesYaounde', compact('enseignements', 'specialite', 'semestre'));
    }

    /**
     * Afficher la page où l'on va renseigner les notes obtenues par les etudiants dans l'ecue choisies.
     *
     * @param  int  $id reprensente l'id de l'enseignement choisi
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id) {

        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        $specialite = $enseignement->specialite->id;
        $cycle = $enseignement->ecue->semestre->cycle->id;
        $sem = $enseignement->ecue->semestre->id;

        // $contrats = $this->contratRepository->findWhere(['specialite_id' => $specialite, 'cycle_id' => $cycle, 'academic_year_id' => $this->anneeAcademic->id]);

        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $specialite)
            ->where('cycle_id', $cycle)
            ->where('contrats.academic_year_id', $enseignement->academic_year_id)
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');

        //Si on est en deuxieme session? on recupere les etudiant qui son alles en 2e session
        $contrats = ($type != 'session2') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($sem){
            $q->where('session', 'session2')->where('semestre_id', $sem);
        })->get();

        $ccComp = true;

        // controller que tous les apprenants ont deja une note de cc;
        foreach($contrats as $contrat){
            if(!$contrat->notes->where('enseignement_id', $enseignement->id)->first() && $type != 'cc')
                $ccComp = false;
        }

        if(!$ccComp){
            Flash::error('Un ou plusieurs apprenants n\'ont pas de note de CC');
            return redirect()->back();
        }
        // dd($enseignement);
        return view('notes.show', compact('enseignement', 'contrats' , 'type'));
    }

    public function showNotes($type, $id, $ville_id) {
        
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        $specialite = $enseignement->specialite->id;
        $semestre = $enseignement->ecue->semestre->id;

        if($ville_id == 3) {
            if($semestre == 1 || $semestre == 2) $cycle = 10;
            else if($semestre == 3 || $semestre == 4) $cycle = 11;
            else if($semestre == 5 || $semestre == 6) $cycle = 12;
            else if($semestre == 7 || $semestre == 8) $cycle = 13;
            else $cycle = 14;
        } else {
            $cycle = $enseignement->ecue->semestre->cycle->id;
        }
        
        // $contrats = $this->contratRepository->findWhere(['specialite_id' => $specialite, 'cycle_id' => $cycle, 'academic_year_id' => $this->anneeAcademic->id]);
        
        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $specialite)
            ->where('cycle_id', $cycle)
            ->where('ville_id', $ville_id)
            ->where('inscription_status', '<>', 'RAS')
            ->where('inscription_status', '<>', 'Abandon')
            ->where('contrats.academic_year_id', $enseignement->academic_year_id)
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');
        
        //Si on est en deuxieme session? on recupere les etudiant qui sont alles en 2e session
        $contrats = ($type != 'session2') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($semestre, $ville_id){
            $q->where('session', 'session2')->where('semestre_id', $semestre)->where('ville_id', $ville_id);
        })->get();

        $ccComp = true;

        // controller que tous les apprenants ont deja une note de cc;
        foreach($contrats as $contrat){
            if(!$contrat->notes->where('enseignement_id', $enseignement->id)->first() && $type != 'cc')
                $ccComp = false;
        }

        if(!$ccComp){
            Flash::error('Un ou plusieurs apprenants n\'ont pas de note de CC');
            return redirect()->back();
        }

        return view('notes.showDouala', compact('enseignement', 'contrats' , 'type', 'ville_id'));
    }

    public function showYaounde($type, $id){
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        $specialite = $enseignement->specialite->id;
        $cycle = $enseignement->ecue->semestre->cycle->id;
        $sem = $enseignement->ecue->semestre->id;

        // $contrats = $this->contratRepository->findWhere(['specialite_id' => $specialite, 'cycle_id' => $cycle, 'academic_year_id' => $this->anneeAcademic->id]);
        
        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $specialite)
            ->where('cycle_id', $cycle)
            ->where('ville_id', 1)
            ->where('contrats.academic_year_id', $enseignement->academic_year_id)
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');

        
        //Si on est en deuxieme session? on recupere les etudiant qui sont alles en 2e session
        $contrats = ($type != 'session2') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($sem){
            $q->where('session', 'session2')->where('semestre_id', $sem);
        })->get();

        $ccComp = true;

        // controller que tous les apprenants ont deja une note de cc;
        foreach($contrats as $contrat){
            if(!$contrat->notes->where('enseignement_id', $enseignement->id)->first() && $type != 'cc')
                $ccComp = false;
        }

        if(!$ccComp){
            Flash::error('Un ou plusieurs apprenants n\'ont pas de note de CC');
            return redirect()->back();
        }
        // dd($enseignement);

        return view('notes.showYaounde', compact('enseignement', 'contrats' , 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, $enseignement, Request $request){
        $input = $request->except('_token', 'DataTables_Table_0_length');
        $enseignement    = $this->enseignementRepository->findWithoutFail($enseignement);
        foreach($input as $key => $value){
            $contrat = $this->contratRepository->findWithoutFail($key);

            $note = $this->noteRepository->updateOrCreate(
                ['enseignement_id' => $enseignement->id, 'contrat_id' => $key],
                [$type => ($value != null) ? $value : 0]
            );
            if($type != 'cc'){
                if($type == 'session1'){
                    $note->del1 = ($note->session1 == 0) ? 0 : $note->cc*0.4 + $note->session1*0.6;
                    $note->save();
                }
                elseif($type == 'session2'){
                    $note->del2 = ($note->session2 == 0) ? 0 : $note->cc*0.4 + $note->session2*0.6;
                    $note->save();
                }
            }
            if($type == 'cc'){//lorsqu'on enregistre le cc apres la note d'examen le syteme recalcule la note finale
                $note->del1 = ($note->del1 != null) ? $note->cc*0.4 + $note->session1*0.6 : null;
                $note->del2 = ($note->del2 != null) ? $note->cc*0.4 + $note->session2*0.6 : null;
                $note->save();
            }

        }
        return redirect()->route('notes.affiche', [$enseignement->ecue->semestre->id, $note->contrat->specialite->id]);
       
        //return redirect()->back()->with([$enseignement->ecue->semestre->id, $note->contrat->specialite->id]);
    }

    public function storeDouala($type, $enseignement, Request $request) {
      
        $input = $request->except('_token', 'DataTables_Table_0_length', 'ville_id');
        
        $enseignement    = $this->enseignementRepository->findWithoutFail($enseignement);
        
        foreach($input as $key => $value) {

            $contrat = $this->contratRepository->findWithoutFail($key);

            $note = $this->noteRepository->updateOrCreate(
                ['enseignement_id' => $enseignement->id, 'contrat_id' => $key],
                [$type => ($value != null) ? $value : 0]
            );
            if($type != 'cc'){
                if($type == 'session1'){
                    $note->del1 = ($note->session1 == 0) ? 0 : $note->cc*0.4 + $note->session1*0.6;
                    $note->save();
                }
                elseif($type == 'session2'){
                    $note->del2 = ($note->session2 == 0) ? 0 : $note->cc*0.4 + $note->session2*0.6;
                    $note->save();
                }
            }
            if($type == 'cc'){//lorsqu'on enregistre le cc apres la note d'examen le syteme recalcule la note finale
                $note->del1 = ($note->del1 != null) ? $note->cc*0.4 + $note->session1*0.6 : null;
                $note->del2 = ($note->del2 != null) ? $note->cc*0.4 + $note->session2*0.6 : null;
                $note->save();
            }

        }
        return redirect()->route('notes.afficheNotes', [$enseignement->ecue->semestre->id, $note->contrat->specialite->id, $request->ville_id]);
       
        //return redirect()->back()->with([$enseignement->ecue->semestre->id, $note->contrat->specialite->id]);
    }

    public function storeYaounde($type, $enseignement, Request $request){
        $input = $request->except('_token', 'DataTables_Table_0_length');
        $enseignement    = $this->enseignementRepository->findWithoutFail($enseignement);
        foreach($input as $key => $value){
            $contrat = $this->contratRepository->findWithoutFail($key);

            $note = $this->noteRepository->updateOrCreate(
                ['enseignement_id' => $enseignement->id, 'contrat_id' => $key],
                [$type => ($value != null) ? $value : 0]
            );
            if($type != 'cc'){
                if($type == 'session1'){
                    $note->del1 = ($note->session1 == 0) ? 0 : $note->cc*0.4 + $note->session1*0.6;
                    $note->save();
                }
                elseif($type == 'session2'){
                    $note->del2 = ($note->session2 == 0) ? 0 : $note->cc*0.4 + $note->session2*0.6;
                    $note->save();
                }
            }
            if($type == 'cc'){//lorsqu'on enregistre le cc apres la note d'examen le syteme recalcule la note finale
                $note->del1 = ($note->del1 != null) ? $note->cc*0.4 + $note->session1*0.6 : null;
                $note->del2 = ($note->del2 != null) ? $note->cc*0.4 + $note->session2*0.6 : null;
                $note->save();
            }

        }
        return redirect()->route('notes.afficheNotesYaounde', [$enseignement->ecue->semestre->id, $note->contrat->specialite->id]);
    }

    /**
     * @param $sem
     * @param $spec
     * @param $session
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * Liste des etudiants à deliberer (possibilité de choisir les etudiants avant delibération)
     *
     */

    public function a_deliberer($sem, $spec, $session, Request $request) {

        $cycle = $this->semestreRepository->findWithoutFail($sem)->cycle->id;
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        if($cycle == 1) {
            $cycle_array = [1, 10];
        } else if($cycle == 2) {
            $cycle_array = [2, 11];
        } else if($cycle == 3) {
            $cycle_array = [3, 12];
        } else if($cycle == 4) {
            $cycle_array = [4, 13];
        } 
        else {
            $cycle_array = [5, 14];
        }
        //on recupere tous les contrats par ordre alphabetique

        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->whereIn('cycle_id', $cycle_array)
            ->where('contrats.academic_year_id', $aa->id)
            //->where('inscription_status', '<>', 'RAS')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');

        //Si on est en deuxieme session? on recupere les etudiants qui son alles en 2e session
        $contrats = ($session == 'session1') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($sem){
            $q->where('session', 'session2')->where('semestre_id', $sem);
        })->get();
       // return $contrats->first();
        if (empty($contrats)) {
            Flash::error('Aucun apprenant dans cette classe');
            return redirect()->back();
        }
        
        return view('notes.a_deliberer', compact('contrats', 'sem', 'session', 'spec'));
    }

    public function pv($sem, $spec, $session, Request $request) {
        
        $id = $request->input('contrat_id');

        if (empty($id)) {
            Flash::error('Selectionnez au moins un étudiant');
            return redirect()->back();
        }
        
        if($sem == '1' || $sem == '2') {
            $cycle_array = [1, 10];
        } else if($sem == '3' || $sem == '4') {
            $cycle_array = [2, 11];
        } else if($sem == '5' || $sem == '6') {
            $cycle_array = [3, 12];
        } else if($sem == '7' || $sem == '8') {
            $cycle_array = [4, 13];
        } 
        else {
            $cycle_array = [5, 14];
        }
        
        //$cycle = $this->semestreRepository->findWithoutFail($sem)->cycle;
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        //on recupere tous les contrats par ordre alphabetique
        
        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            //->where('cycle_id', $cycle->id)
            ->whereIn('cycle_id', $cycle_array)
            ->where('contrats.academic_year_id', $aa->id)
            ->whereIn('contrats.id', $id)
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');
            
        //Si on est en deuxieme session? on recupere les etudiant qui son alles en 2e session
        $contrats = ($session == 'session1') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($sem){
            $q->where('session', 'session2')->where('semestre_id', $sem);
        })->get();

//        dd($contrats, $id, $request->ay_id, $aa->id);

        if (empty($contrats)) {
            Flash::error('Aucun des apprenants selectionnés dans cette classe ne possède de note');
            return redirect()->back();
        }

        $i=0; // increment d'effectif
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $ecues =[];
        $academicYear = $aa;
        $ec = $specialite->ecues->where('semestre_id', $sem)->where('academic_year_id', $academicYear->id);
        // dd($ec);
        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        // $enseignements = $specialite->enseignements->whereIn('ecue_id', $ecues)->where('academic_year_id', $this->anneeAcademic->id);

        $enseignements = Enseignement::whereHas('notes')->whereIn('ecue_id', $ecues)->where('academic_year_id', $aa->id)->where('specialite_id', $specialite->id)->get();

        //$eq = $specialite->ecues->where('academic_year_id', $aa->id)->where('semestre_id', $sem);

        // dd($enseignements);

        $ues = [];
        foreach($enseignements as $enseignement){
            $ues[$enseignement->ue->id] = $enseignement->ue;
        }
        // dd($ues);

        foreach($contrats as $contrat){
            $result = $this->saveNotes($contrat, $enseignements, $session, $sem); // renvoi true si tous les enseignements ont une note de cc
        }

        //Controle pour verifier que tous les apprenants ont des notes enregistrées
        foreach ($contrats as $contrat) {
            foreach ($enseignements->where('ville_id', $contrat->ville_id) as $enseignement) {
                if($enseignement->ville_id == $contrat->ville_id && $contrat->notes->where('enseignement_id', $enseignement->id)->first() == null){
                    Flash::error('L\'etudiant(e) '. $contrat->apprenant->nom .' '. $contrat->apprenant->prenom .' ne possede pas de note de '. $enseignement->ecue->title);
                    return redirect()->back();
                }
            }
        }
        // dd($ec);
        
        $specialityCode = $this->specialityCode[$specialite->slug];
        return view('notes.pv', compact('contrats', 'enseignements', 'ues', 'semestre', 'i', 'academicYear', 'session', 'specialite', 'specialityCode', 'ec' ));
    }

    /**
     * cette fonction est une fonction interne qui permettra d'enregistrer les
     * informations sur le semestre de l'etudiant
     *
     *
     */
    protected function saveNotes($contrat, $enseignements, $session, $semestre) {

        $semestreInfo = $this->semestreInfoRepository->firstOrNew([
            'semestre_id'=> $semestre,
            'contrat_id' => $contrat->id
        ]);
        // dd($session);
        $semestreInfo->session = $session;
        $elimSemestre = false;

        $creditObtsem = 0;
        $nbUeValid = 0;
        $totalSem = 0;
        // dd($session);
        $ues = [];

        foreach ($enseignements->where('ville_id', $contrat->ville_id) as $enseignement){
            $ues[$enseignement->ue_id] = $enseignement->ue;
        }

        foreach ($ues as $ue){
            $ueInfo = $this->ueInfoRepository->firstOrNew(['ue_id' => $ue->id, 'contrat_id' => $contrat->id]);
            $elim = false;
            $creditTot = $enseignements->where('ue_id', $ue->id)->where('ville_id', $contrat->ville_id)->sum('credits');
            $creditObt = 0;
            $totalUe = 0;
            //en fonction des notes enjambement. lorsque ce sera géré.
            $note = 0;

            // $notes=[];
            foreach ($enseignements->where('ue_id', $ue->id)->where('ville_id', $contrat->ville_id) as $enseignement){
                if($contrat->notes->where('enseignement_id', $enseignement->id)->first() == null){
                    return false;
                }



                $note = ($session == 'session1') ? $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 : $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2;
                if ($session == 'session1'){
                    $note = $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 ;
                }
                elseif($session == 'session2'){

                    $del1 = $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1;
                    $del2 = $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2;

                    $note = ($del2 > 0) ? $del2 : $del1;
                    // dd($note);
                }
                elseif($session == 'enjambement'){
                    $note = $contrat->notes->where('enseignement_id', $enseignement->id)->first()->enjambement;
                }
                $totalUe += $note * $enseignement->credits;
                if ($note < 7){
                    $elim = $elimSemestre = true;
                }
                if($note >= 10) {
                    $creditObt += $enseignement->credits;
                }

            }
            
            $ueInfo->creditObt = $creditObt;
            $ueInfo->creditTot = $creditTot;
            $ueInfo->moyenne = $totalUe / $creditTot;
            $ueInfo->totalNotes = $totalUe;

            $totalSem += $ueInfo->totalNotes;


            if(!$elim && $ueInfo->moyenne >= 10){
                $ueInfo->mention = 'Validé';
                $ueInfo->creditObt = $ueInfo->creditTot;
                $nbUeValid +=1;
            }
            else{
                $ueInfo->mention = 'Non Validé';
            }
            $ueInfo->save();
            $creditObtsem += $ueInfo->creditObt;
        }
// dd($totalSem);
        $semestreInfo->moyenne = $totalSem/30;
        $semestreInfo->creditObt = $creditObtsem;
        $semestreInfo->nbUeValid = $nbUeValid;
        $semestreInfo->totalNotes = $totalSem;

        /*
         * Si une ou plusieurs unités d'enseignements n'ont pas obtenus de note eliminatoire,
         * on verifie que l'apprenant a valider au moins (n-1) unités d'enseignement du semestre
         * le cas echeant le semestre est considéré comme non validé
         */
        if(!$elimSemestre && $semestreInfo->moyenne >= 10){
            if($nbUeValid == sizeof($ues)){
                $semestreInfo->mention = 'Validé';
            }
//            elseif(sizeof($ues) > $nbUeValid && (sizeof($ues) - $nbUeValid) ==1){
//                $semestreInfo->mention = 'Validé par Compensation';
//                $semestreInfo->creditObt = 30;
//                $semestreInfo->nbUeValid = sizeof($ues);
//            }
            else{
                $semestreInfo->mention = 'Non Validé';
            }
        }
        else{
            $semestreInfo->mention = 'Non Validé';
        }
        // dd($session);
        if($session == 'session1'){
            $semestreInfo->session = ($semestreInfo->mention == 'Non Validé') ? 'session2' : 'session1';
        }

        $semestreInfo->save();
        return true;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deliberation($sem, $spec, Request $request) {

        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        
        if($semestre->cycle->id == 1) {
            $cycle_array = [1, 10];
        } else if($semestre->cycle->id == 2) {
            $cycle_array = [2, 11];
        } else if($semestre->cycle->id == 3) {
            $cycle_array = [3, 12];
        } else if($semestre->cycle->id == 4) {
            $cycle_array = [4, 13];
        } 
        else {
            $cycle_array = [5, 14];
        }
        
       /*  $contrats = $this->contratRepository->findWhere([
            'specialite_id' => $specialite->id,
            'cycle_id' => $semestre->cycle->id,
            'academic_year_id' => $aa->id,
            ['inscription_status', '<>', 'RAS'],
            ['inscription_status', '<>', 'Abandon'] 
        ]); */

        $contrats = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
        ->select('contrats.*')
        ->where('specialite_id', $specialite->id)
        ->whereIn('cycle_id', $cycle_array)
        ->where('contrats.academic_year_id', $aa->id)
        //->where('inscription_status', '<>', 'RAS')
        ->get();

        return view('notes.deliberation', compact('specialite', 'semestre', 'contrats'));

    }

    public function noteDeliberation($type, $app, $sem){
        $contrat = $this->contratRepository->findWithoutFail($app);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $ecues = $contrat->specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $contrat->academic_year_id); // toutes les ecues de la specialite de l'etudiant.
        $denied = false; //pour verifier que les notes de 1ere session ont ete deja renseignees

        $enseignements = []; //conteneur dans lequel seront chargés tous les enseignements concernés

        foreach($ecues as $ecue){
            $ens = $ecue->enseignements->where('specialite_id', $contrat->specialite_id)->where('academic_year_id', '==', $contrat->academic_year_id)->where('ville_id', $contrat->ville_id)->first();
            ($ens) ? $enseignements[] = $ens : '';
        }
        // dd($enseignements, $contrat->ville_id);

        /**
         * Pour chaque enseigements verifier que l'etudiant possede une note et
         * qu'il possede aussi une note dans la session dans laquelle il va etre delibere.
         */

        foreach ($enseignements as $e){
            if($contrat->notes->where('enseignement_id', $e->id)->first()) {
                if ($contrat->notes->where('enseignement_id', $e->id)->first()->session1 == null)
                    $denied = true;
            }
            else
                $denied = true;
        }

//         if($denied){
//             Flash::error('Veuillez renseigner les notes de '.$type .' de tous les etudiants avant de deliberer');
//             return redirect()->back();
//         }

        return view('notes.noteDeliberation', compact('contrat', 'enseignements', 'type', 'sem'));
    }

    public function saveDeliberation($sem, $type, $contrat, Request $request) {

        $input = $request->except('_token');
        $contrat = $this->contratRepository->findWithoutFail($contrat);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        // dd($input);
        //return $input;
        $arr = [];
        foreach ($input as $key => $value){
            $enseignement = $this->enseignementRepository->findWithoutFail($key);
            $note = $this->noteRepository->findWhere(
                ['enseignement_id' => $enseignement->id, 'contrat_id' => $contrat->id]
            )->first();
           
            // dd(['session'=>$type]);
            if($note) {
                if ($type =='session1'){
                $note->update(['del1'=> $value]);
                }
                elseif ($type == 'session2'){
                    ($value != null) ? $note->update(['del2' => $value]) : "";
                }
            }
        }
        //return $arr;

        $enseignements = $semestre->enseignements->where('specialite_id', $contrat->specialite_id)->where('academic_year_id', $contrat->academic_year_id);

        $this->saveNotes($contrat, $enseignements, $type, $sem);

        // traitement des cas d'enjambement
        if ($type == 'session2' && $semestre->suffixe == 2){
            $this->setResultat($contrat, $semestre);
        }

        return redirect()->route('notes.deliberation',[$semestre->id, $contrat->specialite_id]);

        //return redirect()->back()->with([$semestre->id, $contrat->specialite_id]);
    }

    /*
    public function deliberationDouala($sem, $spec, Request $request){
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        $contrats = $this->contratRepository->findWhere([
            'specialite_id' => $specialite->id,
            'cycle_id' => $semestre->cycle->id,
            'academic_year_id' => $aa->id,
            'ville_id' => 1
        ]);

        return view('notes.deliberationDouala', compact('specialite', 'semestre', 'contrats'));

    }

    public function deliberationYaounde($sem, $spec, Request $request){
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        $contrats = $this->contratRepository->findWhere([
            'specialite_id' => $specialite->id,
            'cycle_id' => $semestre->cycle->id,
            'academic_year_id' => $aa->id,
            'ville_id' => 2
        ]);

        return view('notes.deliberationYaounde', compact('specialite', 'semestre', 'contrats'));

    }
    */


    /*
    public function noteDeliberationDouala($type, $app, $sem){
        $contrat = $this->contratRepository->findWithoutFail($app);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $ecues = $contrat->specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $contrat->academic_year_id); // toutes les ecues de la specialite de l'etudiant.

        $denied = false; //pour verifier que les notes de 1ere session ont ete deja renseignees

        $enseignements = []; //conteneur dans lequel seront chargés tous les enseignements concernés

        foreach($ecues as $ecue){
            $ens = $ecue->enseignements->where('specialite_id', $contrat->specialite_id)->where('ville_id', 1)->where('academic_year_id', '==', $contrat->academic_year_id)->first();
            ($ens) ? $enseignements[] = $ens : '';
        }

        
        //Pour chaque enseigements verifier que l'etudiant possede une note et qu'il possede aussi une note dans la session dans laquelle il va etre delibere.

        foreach ($enseignements as $e){
            if($contrat->notes->where('enseignement_id', $e->id)->first()) {
                if ($contrat->notes->where('enseignement_id', $e->id)->first()->session1 == null)
                    $denied = true;
            }
            else
                $denied = true;
        }

        return view('notes.noteDeliberationDouala', compact('contrat', 'enseignements', 'type', 'sem'));
    }
    */

    /*
    public function noteDeliberationYaounde($type, $app, $sem){
        $contrat = $this->contratRepository->findWithoutFail($app);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $ecues = $contrat->specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $contrat->academic_year_id); // toutes les ecues de la specialite de l'etudiant.

        $denied = false; //pour verifier que les notes de 1ere session ont ete deja renseignees

        $enseignements = []; //conteneur dans lequel seront chargés tous les enseignements concernés

        foreach($ecues as $ecue){
            $ens = $ecue->enseignements->where('specialite_id', $contrat->specialite_id)->where('ville_id', 1)->where('academic_year_id', '==', $contrat->academic_year_id)->first();
            ($ens) ? $enseignements[] = $ens : '';
        }

        // Pour chaque enseigements verifier que l'etudiant possede une note et qu'il possede aussi une note dans la session dans laquelle il va etre delibere.
         
        foreach ($enseignements as $e){
            if($contrat->notes->where('enseignement_id', $e->id)->first()) {
                if ($contrat->notes->where('enseignement_id', $e->id)->first()->session1 == null)
                    $denied = true;
            }
            else
                $denied = true;
        }

        return view('notes.noteDeliberationYaounde', compact('contrat', 'enseignements', 'type', 'sem'));
    }
    */

    protected function setResultat($contrat, $semestre){
        $resultat = $this->resultatNominatifsRepository->firstOrNew(['contrat_id' => $contrat->id]);

        if ($semestre->cycle_id != 3 && $semestre->cycle_id != 5){

            if ($semestre->cycle->niveau == 1){
                $credits = $contrat->semestre_infos->sum('creditObt');
                $nb_sem_val = $contrat->semestre_infos->where('credtiObt', 30)->count();

                /** L'apprenant a validé le semestre **/

                if ($nb_sem_val == 2){
                    $resultat->next_cycle_id = $contrat->cycle_id + 1;
                    $resultat->decision = 'Admis';
                    $resultat->save();
                }
                elseif($nb_sem_val < 2 && $credits >= 45){
                    if ($nb_sem_val == 1 || $contrat->semestre_infos->where('creditObt', '>=', 23)){
                        $resultat->next_cycle_id = $contrat->cycle_id + 1;
                        $resultat->decision = 'Enjambement';
                        $resultat->save();
                    }
                    else{
                        $resultat->next_cycle_id = $contrat->cycle_id;
                        $resultat->decision = 'Redouble';
                        $resultat->save();
                    }
                }
                else{
                    $resultat->next_cycle_id = $contrat->cycle_id;
                    $resultat->decision = 'Redouble';
                    $resultat->save();
                }
            }
            elseif ($semestre->cycle->niveau == 2){ /** L'apprenant est en licence 2 **/
                if($contrat->academic_year_id != $contrat->apprenant->academic_year_id && $contrat->apprenant->academic_year_id != 1){ /** anciens apprenants de Pigier */
                    $credits = $contrat->apprenant->semestre_infos->sum('creditObt');
                    $nb_sem_val = $contrat->apprenant->semestre_infos->where('creditObt', 30)->count();

                    if ($credits == 120){
                        $resultat->next_cycle_id = $contrat->cycle_id + 1;
                        $resultat->decision = 'Admis';
                        $resultat->save();
                    }
                    /**
                     * Anciens apprenant de licence 2 pouvant etre en situation d'enjambement
                     **/
                    elseif ($credits >= 90 && $nb_sem_val >= 2 && $contrat->apprenant->semestre_infos->where('creditObt', '>=', 15)->count() == 4){
                        /** Egal à 4 car deux semestres sont supposé avoir 30 credits */
                        $resultat->next_cycle_id = $contrat->cycle_id + 1;
                        $resultat->decision = 'Enjambement';
                        $resultat->save();
                    }
                    else{
                        $resultat->next_cycle_id = $contrat->cycle_id;
                        $resultat->decision = 'Redouble';
                        $resultat->save();
                    }
                }
            }
        }
    }

    public function rattrapage($sem, $spec, $ville_id, Request $request){

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $app = $this->contratRepository->findWhere(['specialite_id' => $specialite->id, 'cycle_id' => $semestre->cycle_id, 'academic_year_id' => $aa->id, 'ville_id' => $ville_id]);

        $contrats = [];

        $enseignements= [];

        foreach($app as $contrat){
            $ens =[];
            $semestreInfo = $contrat->semestre_infos->where('semestre_id', $semestre->id)->first();
            if (!$semestreInfo){
                Flash::error('Veuillez deliberer tous les etudiants avant svp');
                return redirect()->back();
            }

            if($semestreInfo->mention == 'Non Validé'){
                $contrats[] = $contrat;
                foreach($contrat->ue_infos as $ueInfo){
                    if($ueInfo->mention == 'Non Validé'){
                        foreach ($contrat->notes as $note) {
                            if ($note->enseignement->ue_id == $ueInfo->ue_id && $note->del1 < 10) {
                                $ens[$note->enseignement->ecue->title] = $note->enseignement;
                            }
                        }
                        $enseignements[$ueInfo->ue->title] = $ens;
                    }
                }
            }
            $enseignements[$contrat->id] = $ens;
        }
        return view('notes.rattrapage', compact('contrats', 'enseignements', 'ville_id'));
    }
    // Afficher les apprenants de Douala en deuxième session
    public function rattrapageDLA($sem, $spec, Request $request){

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $app = $this->contratRepository->findWhere(['specialite_id' => $specialite->id, 'cycle_id' => $semestre->cycle_id, 'academic_year_id' => $aa->id, 'ville_id' => 1]);

        $contrats = [];

        $enseignements= [];

        foreach($app as $contrat){
            $ens =[];
            $semestreInfo = $contrat->semestre_infos->where('semestre_id', $semestre->id)->first();
            if (!$semestreInfo){
                Flash::error('Veuillez deliberer tous les etudiants avant svp');
                return redirect()->back();
            }

            if($semestreInfo->mention == 'Non Validé'){
                $contrats[] = $contrat;
                foreach($contrat->ue_infos as $ueInfo){
                    if($ueInfo->mention == 'Non Validé'){
                        foreach ($contrat->notes as $note) {
                            if ($note->enseignement->ue_id == $ueInfo->ue_id && $note->del1 < 10) {
                                $ens[$note->enseignement->ecue->title] = $note->enseignement;
                            }
                        }
                        $enseignements[$ueInfo->ue->title] = $ens;
                    }
                }
            }
            $enseignements[$contrat->id] = $ens;
        }
        return view('notes.rattrapage', compact('contrats', 'enseignements'));
    }

    // Afficher les apprenants de Yaoundé en deuxième session
    public function rattrapageYDE($sem, $spec, Request $request){

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $app = $this->contratRepository->findWhere(['specialite_id' => $specialite->id, 'cycle_id' => $semestre->cycle_id, 'academic_year_id' => $aa->id, 'ville_id' => 2]);

        $contrats = [];

        $enseignements= [];

        foreach($app as $contrat){
            $ens =[];
            $semestreInfo = $contrat->semestre_infos->where('semestre_id', $semestre->id)->first();
            if (!$semestreInfo){
                Flash::error('Veuillez deliberer tous les etudiants avant svp');
                return redirect()->back();
            }

            if($semestreInfo->mention == 'Non Validé'){
                $contrats[] = $contrat;
                foreach($contrat->ue_infos as $ueInfo){
                    if($ueInfo->mention == 'Non Validé'){
                        foreach ($contrat->notes as $note) {
                            if ($note->enseignement->ue_id == $ueInfo->ue_id && $note->del1 < 10) {
                                $ens[$note->enseignement->ecue->title] = $note->enseignement;
                            }
                        }
                        $enseignements[$ueInfo->ue->title] = $ens;
                    }
                }
            }
            $enseignements[$contrat->id] = $ens;
        }
        return view('notes.rattrapage', compact('contrats', 'enseignements'));
    }



    public function getNoteContrat($contrat, $enseignement){
        $note = $this->noteRepository->findWhere(['enseignement_id' => $enseignement, 'contrat_id' => $contrat]);
        return response()->json($note);
    }

    public function imprime($sem, $specialite, Request $request) {

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        
        $cycle = $semestre->cycle->id;

        if($cycle == 1) {
            $cycle_array = [1, 10];
        } else if($cycle == 2) {
            $cycle_array = [2, 11];
        } else if($cycle == 3) {
            $cycle_array = [3, 12];
        } else if($cycle == 4) {
            $cycle_array = [4, 13];
        } 
        else {
            $cycle_array = [5, 14];
        }
        //on recupere tous les contrats par ordre alphabetique

        $contrats = Contrat::select('contrats.*')
            ->where('specialite_id', $specialite)
            ->whereIn('cycle_id', $cycle_array)
            ->where('contrats.academic_year_id', $aa->id)
            //->where('inscription_status', '<>', 'RAS')
            ->get();
        /* $contrats = $this->contratRepository->findWhere([
            'specialite_id' => $specialite, 
            'cycle_id' => $semestre->cycle_id, 
            'academic_year_id' => $aa->id,
        ]); */

        return view('notes.imprime', compact('contrats', 'semestre'));
    }

    public function releve($session, $contrat, $semestre) {

        $contrat = $this->contratRepository->findWithoutFail($contrat);
        
        $academicYear = $contrat->academic_year;

        $semestre = $this->semestreRepository->findWithoutFail($semestre);

        $enseignements = $semestre->enseignements->where('specialite_id', $contrat->specialite_id)->where('ville_id', $contrat->ville_id)->where('academic_year_id', $contrat->academic_year_id);

        foreach ($enseignements as $enseignement) {
            if($contrat->notes->where('enseignement_id', $enseignement->id)->first() == null){
                Flash::error('L\'etudiant(e) '. $contrat->apprenant->nom .' '. $contrat->apprenant->prenom .' ne possede pas de note de '. $enseignement->ecue->title);
                return redirect()->back();
            }
        }
        $ues = [];

        foreach ($enseignements as $enseignement) {
            $ues[$enseignement->ue_id] = $enseignement->ue;
        }
        //return $ues;
        $specialityCode = $this->specialityCode[$contrat->specialite->slug];

        return view('notes.rnr_imprime', compact('contrat', 'semestre', 'enseignements', 'ues', 'academicYear', 'session', 'specialityCode'));
    }

    public function rn_intermediaire($sem, $spec, $ville_id, $session, Request $request) {
        
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);
        $ville = $this->villeRepository->findWithoutFail($ville_id);

        if($ville_id == 3) {
            if($sem == 1 || $sem == 2) $cycle = 10;
            else if($sem == 3 || $sem == 4) $cycle = 11;
            else if($sem == 5 || $sem == 6) $cycle = 12;
            else if($sem == 7 || $sem == 8) $cycle = 13;
            else $cycle = 14;
        } else {
            $cycle = $this->semestreRepository->find($sem)->cycle->id;
        }

        $c = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->where('cycle_id', $cycle)
            ->where('ville_id', $ville_id)
            ->where('contrats.academic_year_id', $aa->id)
            ->where('inscription_status', '<>', 'RAS')
            ->where('inscription_status', '<>', 'Abandon') 
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom');

        $contrats = ($session == 'session1') ? $c->get() : $c->whereHas('semestre_infos', function($q) use ($sem){
            $q->where('session', 'session2')->where('semestre_id', $sem);
        })->get();

        $type = $session;
        $i=0;
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $ecues =[];
        $academicYear = $this->anneeAcademic;
        $ec = $specialite->ecues->where('semestre_id', $sem);
        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        $enseignements = $specialite->enseignements->whereIn('ecue_id', $ecues)->where('academic_year_id', $aa->id)->where('ville_id', $ville_id);
        
        return view('notes.rn_intermediaire', compact('contrats', 'enseignements', 'semestre', 'i', 'academicYear', 'session', 'ville'));
    }

    public function pvcc($sem, $spec, $ville_id = null, Request $request) {

        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        if($ville_id == 3) {
            if($sem == 1 || $sem == 2) $cycle = 10;
            else if($sem == 3 || $sem == 4) $cycle = 11;
            else if($sem == 5 || $sem == 6) $cycle = 12;
            else if($sem == 7 || $sem == 8) $cycle = 13;
            else $cycle = 14;
        } else {
            $cycle = $this->semestreRepository->find($sem)->cycle->id;
        }
        //$cycle = $this->semestreRepository->findWithoutFail($semestre->id)->cycle;

        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $ville_id ? $contrats = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->where('cycle_id', $cycle)
            ->where('ville_id', $ville_id)
            ->where('contrats.academic_year_id', $aa->id)
            ->where('inscription_status', '<>', 'RAS')
            ->where('inscription_status', '<>', 'Abandon')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get():

        $contrats = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->where('cycle_id', $cycle)
            ->where('contrats.academic_year_id', $aa->id)
            ->where('inscription_status', '<>', 'RAS')
            ->where('inscription_status', '<>', 'Abandon')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get();

        $ecues =[];
        $academicYear = $aa;
        $ec = $specialite->ecues->where('semestre_id', $sem);

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        
        $enseignements = $specialite->enseignements
        ->where('academic_year_id', $aa->id)
        ->whereIn('ecue_id', $ecues);
        
        
        $eq = $specialite->ecues->where('academic_year_id', $aa->id)->where('semestre_id', $sem);
        //dd($eq);
        return view('notes.pvcc', compact('contrats', 'enseignements', 'academicYear', 'semestre', 'eq'));
    }

    public function pvcc_dla($sem, $spec, Request $request){
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $cycle = $this->semestreRepository->findWithoutFail($semestre->id)->cycle;

        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $contrats = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->where('cycle_id', $cycle->id)
            ->where('contrats.academic_year_id', $aa->id)
            ->where('inscription_status', '<>', 'RAS')
            ->where('ville_id', 1)
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get();

        $ecues =[];
        $academicYear = $aa;
        $ec = $specialite->ecues->where('semestre_id', $sem);
        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        
        $enseignements = $specialite->enseignements
        ->where('academic_year_id', $aa->id)
        ->where('ville_id', 1)
        ->whereIn('ecue_id', $ecues);

        $eq = $specialite->ecues->where('academic_year_id', $aa->id)->where('semestre_id', $sem);
        return view('notes.pvcc', compact('contrats', 'enseignements', 'academicYear', 'semestre', 'eq'));
    }

        public function pvcc_yde($sem, $spec, Request $request){
        $specialite = $this->specialiteRepository->findWithoutFail($spec);
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $cycle = $this->semestreRepository->findWithoutFail($semestre->id)->cycle;

        $aa = ($request->ay_id == null) ? $this->anneeAcademic : $this->academicYearRepository->findWithoutFail($request->ay_id);

        $contrats = Contrat::join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->where('specialite_id', $spec)
            ->where('cycle_id', $cycle->id)
            ->where('contrats.academic_year_id', $aa->id)
            ->where('ville_id', 1)
            ->where('inscription_status', '<>', 'RAS')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get();

        $ecues =[];
        $academicYear = $aa;
        $ec = $specialite->ecues->where('semestre_id', $sem);
        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        
        $enseignements = $specialite->enseignements
        ->where('academic_year_id', $aa->id)
        ->where('ville_id', 1)
        ->whereIn('ecue_id', $ecues);

        $eq = $specialite->ecues->where('academic_year_id', $aa->id)->where('semestre_id', $sem);
        
        return view('notes.pvcc', compact('contrats', 'enseignements', 'academicYear', 'semestre', 'eq'));
    }

    /**
     * API methods definition Start
    */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDataForLockNotes() {

        $this->middleware(['role:Admin']);
        
        $academicYears = $this->academicYearRepository->all();

        $academic = [];

        foreach ($academicYears as $a) {
            $academic[$a->id] = $a->debut.'/'.$a->fin;
        }

        return view('notes.lock', compact('academic')); 
      
    }

    public function lock_notes($session, $academicYear, $semester) {
       
        $this->middleware(['role:Admin']);
 
        $academic = $this->academicYearRepository->find($academicYear);
        if($semester == '1' || $semester == '2') $policies = $academic->policies->whereIn('cycle_id', [1, 10]);
        else if($semester == '3' || $semester == '4') $policies = $academic->policies->whereIn('cycle_id', [2, 11]);
        else if($semester == '5' || $semester == '6') $policies = $academic->policies->whereIn('cycle_id', [3, 12]);
        else if($semester == '7' || $semester == '8') $policies = $academic->policies->whereIn('cycle_id', [4, 13]);
        else $policies = $academic->policies()->whereIn('cycle_id', [5, 14]); 
        
        $dataArray = json_decode($policies, true);
        $transformedArray = array_values($dataArray);

        $ens_ids = $academic->enseignements->where('semester_id', $semester)->pluck('id');

        //return $policies = $academic->policies->notes()->whereIn('enseignement_id', $ens_ids);

        DB::beginTransaction();
       
        try {

            foreach ($transformedArray as $policy) {
                
                $notes = $policy->notes->whereIn('enseignement_id', $ens_ids);
                
                if($notes || $notes->count() > 0) {
                    
                    foreach($notes as $note) {

                        $session === 'session1' ? 
                            $note->state_session1 = !$note['state_session1']
                            :
                            $note->state_session2 = !$note['state_session2'];
                        $note->save(); 
                    }

                }

            }

        DB::commit();

         } catch (\Exception $e) {
            DB::rollback();
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        } 

        return [
            "success" => true,
            "message" => "Opération faite avec succès"
        ];
        
    }
}
