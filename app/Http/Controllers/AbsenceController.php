<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicYear as AnneeAcademic;
use App\Http\Requests\CreateAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\Models\Absence;
use App\Models\AcademicYear;
use App\Models\Apprenant;
use App\Models\Contrat;
use App\Repositories\AbsenceRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ApprenantRepository;
use App\Repositories\ContratRepository;
use App\Repositories\CycleRepository;
use App\Repositories\EcueRepository;
use App\Repositories\EnseignementRepository;
use App\Repositories\SemestreRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\VilleRepository;
use App\Transformers\ApprenantTransformer;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Yajra\DataTables\Datatables;
use DB;
use Yajra\DataTables\Html\Builder;
use App\Transformers;

class AbsenceController extends AppBaseController
{
    /** @var  AbsenceRepository */
    private $absenceRepository;
    protected $specialiteRepository;
    protected $ecueRepository;
    protected $semestreRepository;
    protected $cycleRepository;
    protected $apprenantRepository;
    protected $contratRepository;
    protected $academicYear;
    protected $enseignementRepository;
    protected $villeRepository;

    public function __construct(AbsenceRepository $absenceRepo,ApprenantRepository $apprenantRepository,
                                CycleRepository $cycleRepository, EcueRepository $ecueRepository, ContratRepository $contratRepository,
                                SpecialiteRepository $specialiteRepository, SemestreRepository $semestreRepository,
                                Request $request, AnneeAcademic $academicYear, EnseignementRepository $enseignementRepository, VilleRepository $villeRepository)
    {
        if (request()->server("SCRIPT_NAME") !== 'artisan') {

            if ($request->route()->getName() == 'absences.store')
                $this->middleware(['permission:create absences']);
            if ($request->route()->getName() == 'absences.update')
                $this->middleware(['permission:edit absences']);
        }



        $this->absenceRepository = $absenceRepo;
        $this->specialiteRepository = $specialiteRepository;
        $this->ecueRepository = $ecueRepository;
        $this->semestreRepository = $semestreRepository;
        $this->cycleRepository = $cycleRepository;
        $this->apprenantRepository = $apprenantRepository;
        $this->contratRepository = $contratRepository;
        $this->academicYear = AcademicYear::find($academicYear::getCurrentAcademicYear());
        $this->enseignementRepository = $enseignementRepository;
        $this->villeRepository = $villeRepository;
    }

    /**
     * Display a listing of the Absence.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
//        $this->absenceRepository->pushCriteria(new RequestCriteria($request));
//        $absences = $this->absenceRepository->all();
//
//        return view('absences.index')
//            ->with('absences', $absences);
        $cycles = $this->cycleRepository->all();
        return view('index', compact('cycles'));
    }

    public function search($n, $ville_id) {
        $specialites = $this->specialiteRepository->all();
        $cycles = $this->cycleRepository->all();
        /*
        if($n == '1')
            $method = 'create';
        elseif($n == '2')
            $method = 'affiche';
        */
        if($n == '1')
            $method = 'createAbsence';
        elseif($n == '3')
            $method = 'afficheAbsence';
        elseif($n == '5')
            $method = 'ficheAbsence';
        $model = 'absences';

        return view('search',compact('cycles','model', 'method', 'ville_id'));
    }

    /**
     * Show the form for creating a new Absence.
     *
     * @return Response
     */
    public function create($semestre, $specialite)
    {
        //$semestres = $this->semestreRepository->findWithoutFail($semestre);
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);
        $cycle = $this->semestreRepository->find($semestre)->cycle;
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->academicYear->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id]);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }
        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->academicYear->id)->where('specialite_id', $specialite);
        foreach ($ens as $enseignement){
            $enseignements[$enseignement->ecue->id] = $enseignement->ecue->title;
        }

        return view('absences.create', compact('enseignements','contrats'));
    }

    /** Fonction permettant d'afficher le formulaire de création des absences à Douala */
    public function createAbsence($semestre, $specialite, $ville_id)
    {
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);
        $cycle = $this->semestreRepository->find($semestre)->cycle;
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->academicYear->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id, 'ville_id' => $ville_id]);
        $city = $this->villeRepository->findWithoutFail($ville_id);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->academicYear->id)->where('specialite_id', $specialite)->where('ville_id', $ville_id);
        foreach ($ens as $enseignement){
            $enseignements[$enseignement->ecue->id] = $enseignement->ecue->title;
        }

        return view('absences.createDouala', compact('enseignements','contrats', 'city'));
    }

    /** Fonction permettant d'afficher le formulaire de création des absences à Yaoundé */ 
    public function createYaounde($semestre, $specialite){
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);
        $cycle = $this->semestreRepository->find($semestre)->cycle;
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->academicYear->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id, 'ville_id' => 2]);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->academicYear->id)->where('specialite_id', $specialite)->where('ville_id', 2);
        foreach ($ens as $enseignement){
            $enseignements[$enseignement->ecue->id] = $enseignement->ecue->title;
        }


        return view('absences.createYaounde', compact('enseignements','contrats'));
    }

    /**
     * Store a newly created Absence in storage.
     *
     * @param CreateAbsenceRequest $request
     *
     * @return Response
     */
    public function store(CreateAbsenceRequest $request)
    {
        // $input = $request->except('apprenant_id');
        $contrat_id = $request->input('contrat_id');
        $ecue = $this->ecueRepository->findWithoutFail( $request->input('ecue_id'));
        $date = $request->input('date');
        $justify = false;
        $justification = null;

        // $absence = $this->absenceRepository->create($input);

        foreach($contrat_id as $contrat){
            Absence::create(['contrat_id' => $contrat, 'date' => $date, 'ecue_id' => $ecue->id, 'justify' => $justify]);
        }

        $model = 'absences';
        $c = $this->cycleRepository->all();
        Flash::success('Absence saved successfully.');

        return redirect(url('absences/search/1/'.$request->input('ville_id')));
    }

    public function etat(){
        $specialites = $this->specialiteRepository->all();
        $cycles = $this->cycleRepository->all();

        return view('absences.etat',compact('cycles'));
    }

    public function affiche($semestre, $specialite){

        $sem = $this->semestreRepository->findWithoutFail($semestre);
        $cycle = $this->semestreRepository->findWithoutFail($semestre)->cycle;

        $ec = $this->ecueRepository->findWhere(['semestre_id' => $sem->id]);
        $ecues = [];

        foreach($ec as $e){
            $ecues[] = $e->id;
        }

        $contrats = $this->contratRepository->findWhere([
            'specialite_id'=>$specialite,
            'cycle_id' => $cycle->id,
        ]);

        $absences = $contrats->first()->absences->whereIn('ecue_id', $ecues)->where('justify',0)->count();

        return view('absences.affiche', compact('contrats', 'sem', 'ecues'));
    }

    public function afficheAbsence($semestre, $specialite, $ville_id) {

        $sem = $this->semestreRepository->findWithoutFail($semestre);
        $city = $this->villeRepository->findWithoutFail($ville_id);

        if($ville_id == 3) {
            if($semestre == 1 || $semestre == 2) $cycle = 10;
            else if($semestre == 3 || $semestre == 4) $cycle = 11;
            else if($semestre == 5 || $semestre == 6) $cycle = 12;
            else if($semestre == 7 || $semestre == 8) $cycle = 13;
            else $cycle = 14;
        } else {
            $cycle = $this->semestreRepository->find($semestre)->cycle->id;
        }
       

        $ec = $this->ecueRepository->findWhere(['semestre_id' => $sem->id]);
        $ecues = [];

        foreach($ec as $e){
            $ecues[] = $e->id;
        }

        $contrats = $this->contratRepository->findWhere([
            'specialite_id'=>$specialite,
            'cycle_id' => $cycle,
            'ville_id' => $ville_id
        ]);

        $absences = $contrats->first()->absences->whereIn('ecue_id', $ecues)->where('justify',0)->count();

        return view('absences.afficheDouala', compact('contrats', 'sem', 'ecues', 'city'));
    }

    public function afficheYaounde($semestre, $specialite){

        $sem = $this->semestreRepository->findWithoutFail($semestre);
        $cycle = $this->semestreRepository->findWithoutFail($semestre)->cycle;

        $ec = $this->ecueRepository->findWhere(['semestre_id' => $sem->id]);
        $ecues = [];

        foreach($ec as $e){
            $ecues[] = $e->id;
        }

        $contrats = $this->contratRepository->findWhere([
            'specialite_id'=>$specialite,
            'cycle_id' => $cycle->id,
            'ville_id' => 2
        ]);

        $absences = $contrats->first()->absences->whereIn('ecue_id', $ecues)->where('justify',0)->count();

        return view('absences.afficheYaounde', compact('contrats', 'sem', 'ecues'));
    }

    /** Fiche de présence par ecue Douala */ 
    public function ficheAbsence($semestre, $specialite, $ville_id) {

        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);
        $city = $this->villeRepository->findWithoutFail($ville_id);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->academicYear->id)->where('specialite_id', $specialite)->where('ville_id', $ville_id);
        
        return view('absences.fiche-douala', compact('ec', 'semestre', 'specialite', 'ens', 'city'));
    }

    public function ficheEcue($semestre, $specialite, $id, $ville_id) {
      
        $city = $this->villeRepository->findWithoutFail($ville_id);
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        
        if($ville_id == 3) {
           if($semestre == 1 || $semestre == 2) $cycle = 10;
           else if($semestre == 3 || $semestre == 4) $cycle = 11;
           else if($semestre == 5 || $semestre == 6) $cycle = 12;
           else if($semestre == 7 || $semestre == 8) $cycle = 13;
           else $cycle = 14;
        } else {
            $cycle = $this->semestreRepository->find($semestre)->cycle->id;
        }

        /*
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->academicYear->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id]);
        */
        
        $filter1 = $this->academicYear->id;
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

        return view('absences.fiche-presence-douala', compact('enseignement', 'apprenants', 'city'));
    }

    public function ficheYaounde($semestre, $specialite){
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $specialites->ecues->where('semestre_id', $semestre);

        $ecues= array();
        $enseignements = [];

        foreach($ec as $ecue){
            $ecues[] = $ecue->id;
        }

        $ens = $this->enseignementRepository->findWhereIn('ecue_id', $ecues)->where('academic_year_id', $this->academicYear->id)->where('specialite_id', $specialite)->where('ville_id', 2);
        
        return view('absences.fiche-yaounde', compact('ec', 'semestre', 'specialite', 'ens'));
    }

    public function ficheEcueYaounde($semestre, $specialite, $id){
        $specialites = $this->specialiteRepository->findWithoutFail($specialite);
        $cycle = $this->semestreRepository->find($semestre)->cycle;
        /*
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $this->academicYear->id,'cycle_id'=> $cycle->id, 'specialite_id' => $specialites->id]);
        */
        
        $filter1 = $this->academicYear->id;
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

        return view('absences.fiche-presence-yaounde', compact('enseignement', 'apprenants'));
    }

    /**
     * Display the specified Absence.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $absence = $this->absenceRepository->findWithoutFail($id);

        if (empty($absence)) {
            Flash::error('Absence not found');

            return redirect(route('absences.index'));
        }

        return view('absences.show')->with('absence', $absence);
    }

    /**
     * Show the form for editing the specified Absence.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($contrat, $semestre)
    {
        $contrat = $this->contratRepository->with('absences')->findWithoutFail($contrat);
        if($contrat->ingoing) {
            $contrat->ingoing->delete();
        }
        $sem = $this->semestreRepository->findWithoutFail($semestre);

//        if (empty($absence)) {
//            Flash::error('Absence not found');
//
//            return redirect(route('absences.index'));
//        }

        $ec = $this->ecueRepository->findWhere(['semestre_id' => $sem->id]);
        $ecues = [];

        foreach($ec as $e){
            $ecues[] = $e->id;
        }

        return view('absences.edit', compact('contrat','sem', 'ecues' ));
    }

    public function updateJustif($justification, $absence){
        $absence = $this->absenceRepository->findWithoutFail($absence);
        $absence->justification = $justification;
        $absence->justify = true;
        $absence->save();
        Flash::success('Absence justifiée');

        return back();
    }

    /**
     * Update the specified Absence in storage.
     *
     * @param  int              $id
     * @param UpdateAbsenceRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $absence = $this->absenceRepository->findWithoutFail($id);

        if (empty($absence)) {
            Flash::error('Absence not found');

            return redirect(route('absences.index'));
        }
        $absence->justification = $request->input('justification');
        $absence->justify = (int)$request->input('justify');
        $absence->save();
        Flash::success('Absence updated successfully.');

        return redirect(route('absences.etat'));
    }

    /**
     * Remove the specified Absence from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $absence = $this->absenceRepository->findWithoutFail($id);

        if (empty($absence)) {
            Flash::error('Absence not found');

            return redirect(route('absences.index'));
        }

        $this->absenceRepository->delete($id);

        Flash::success('Absence deleted successfully.');

        return redirect(route('absences.index'));
    }

    public function test(){
        $apprenant = $this->apprenantRepository->all();

        return view('DataTables.test', compact('apprenant'));
    }
}
