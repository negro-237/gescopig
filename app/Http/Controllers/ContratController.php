<?php

namespace App\Http\Controllers;
use App\DataTables\ContratDataTable;
use App\Helpers\AcademicYear as Inscrip;
use App\Http\Requests\ContratRequest;
use App\Http\Requests\UpdateContratRequest;
use App\Models\AcademicYear;
use App\Models\Apprenant;
use App\Models\Contrat;
use App\Models\Ville;
use App\User;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ApprenantRepository;
use App\Repositories\ContratRepository;
use App\Repositories\CycleRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\VilleRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use DB;
use App\Notifications\SendMailStudentNotification;


class ContratController extends Controller
{
    protected $apprenantRepository;
    protected $specialiteRepository;
    protected $cycleRepository;
    protected $anneeAcademique;
    protected $contratRepository;
    protected $academicYearRepository;
    protected $villeRepository;

    public function __construct(ContratRepository $contratRepository, AcademicYearRepository $academicYearRepository ,ApprenantRepository $apprenantRepository, SpecialiteRepository $specialiteRepository, CycleRepository $cycleRepository, VilleRepository $villeRepository)
    {
        $this->contratRepository = $contratRepository;
        $this->apprenantRepository = $apprenantRepository;
        $this->specialiteRepository = $specialiteRepository;
        $this->cycleRepository = $cycleRepository;
        $inscrip = Inscrip::getCurrentAcademicYear();
        $this->anneeAcademique = AcademicYear::find($inscrip);
        $this->academicYearRepository = $academicYearRepository;
        $this->villeRepository = $villeRepository;
    }

    /**
     * Afficher les contrats de tous les apprenants enregistrés pour l'année en cours
     * @return \Illuminate\Http\Response
     */
    public function index(ContratDataTable $contratDataTable)
    {

        // Compter tous les contrats en attente
        $awaitingContrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('state', '=', 'En attente')
        ->count();

        // Compter tous les contrats retournés
        $countReturnedContrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('state', '!=', 'En attente')
        ->where('state', '!=', 'Etabli')
        ->where('state', '!=', 'En Attente de Retour')
        ->count();

        // Compter tous les contrats en attente de retour
        $awaitingReturnContrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->whereIn('state', ['Etabli', 'En Attente de Retour'])
        ->count();

        // Compter tous les apprenants en règle pour l'année en cours
        $goodLearner = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Apprenant en règle')
        ->count();

        // Compter tous les apprenants inscrits pour l'année en cours
        $registeredLearner = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Inscrit')
        ->count();

        // Compter tous les apprenants inscrits avec moratoire pour l'année en cours
        $registeredLearnerWithMoratorium = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Inscrit avec moratoire')
        ->count();

        // Compter tous les contrats de l'année en cours
        $countAllContrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)->count();

        // Récupérer tous les contrats de l'année en cours
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)->get();

        /**
         * 
         * $contrats = Contrat::where('academic_year_id', '=', $this->anneeAcademique->id)
            ->where('cycle_id', '=', 3)
            ->get();
         * 
        **/

        
        return view('contrats.index', compact('contrats', 'countAllContrats', 'countReturnedContrats', 'awaitingReturnContrats', 'awaitingContrats', 'goodLearner', 'registeredLearner', 'registeredLearnerWithMoratorium'));
    }

    /**
     * Afficher tous les contrats des étudiants pour toutes les années confondues
     */
    public function all(){
        $contrats = $this->contratRepository->all();

        return view('contrats.all', compact('contrats'));
    }

    /**
     * Afficher tous les contrats en attente pour l'année en cours
     */
    public function awaiting(ContratDataTable $contratDataTable){
        
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('state', '=', 'En attente')
        ->get();

        return view('contrats.awaiting', compact('contrats'));
    }

    /**
     * Afficher tous les contrats en attente de retour 
     */
    public function awaitingReturn(ContratDataTable $contratDataTable){

        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->whereIn('state', ['Etabli', 'En Attente de Retour'])
        ->get();

        return view('contrats.awaiting-return', compact('contrats'));
    }

    /**
     * Afficher tous les contrats retournés
     */
    public function returned(ContratDataTable $contratDataTable){

        // Récupérer tous les contrats retournés
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('state', '!=', 'En attente')
        ->where('state', '!=', 'Etabli')
        ->where('state', '!=', 'En Attente de Retour')
        ->get();

        return view('contrats.returned', compact('contrats'));
    }

    /**
     * Afficher tous les apprenants en règle
     */
    public function learner(){

        // Récupérer tous les apprenants en règle pour l'année en cours
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Apprenant en règle')
        ->get();

        return view('contrats.learner', compact('contrats'));
    }

    /**
     * Afficher tous les apprenants inscrits
     */
    public function registeredLearner(){

        // Récupérer tous les apprenants inscrits pour l'année en cours
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Inscrit')
        ->get();

        return view('contrats.registered-learner', compact('contrats'));
    }

    /**
     * Afficher tous les apprenants inscrits avec un moratoire
     */
    public function registeredLearnerWithMoratorium(){
        // Récupérer tous les apprenants inscrits avec un moratoire pour l'année en cours
        $contrats = Contrat::where('academic_year_id', '>=', $this->anneeAcademique->id)
        ->where('inscription_status', 'Inscrit avec moratoire')
        ->get();

        return view('contrats.registered-learner-moratorium', compact('contrats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = $this->academicYearRepository->orderBy('id', 'desc')->first();
        $contrats = $this->contratRepository->findWhere(['academic_year_id' => $years->id]);

        $app=[];
        foreach($contrats as $contrat){
            array_push($app,$contrat->apprenant_id);
        }

        $apprenants = $this->apprenantRepository
            ->orderBy('id', 'desc')
            ->findWhereNotIn('id', $app); // on retrouve tous les apprenants qui n'ont pas encore de contrats dans la base de données
        $spe = $this->specialiteRepository->all();
        $c = $this->cycleRepository->all();
        $cycles = array();
        $specialites = array();
        $academicYears = [];
        $ay = $this->academicYearRepository->all();
        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }

        foreach($c as $cycle){
            $specialites[$cycle->label] = $cycle->specialites->pluck('title', 'id')->toArray();
        }

        foreach($c as $cycle){
            $cycles[$cycle->id] = $cycle->label. ' ' .$cycle->niveau;
        }

        $villes = Ville::all();
        return view('contrats.create', compact('apprenants', 'specialites', 'cycles', 'academicYears', 'villes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContratRequest $request)
    {
        $apprenant = $this->apprenantRepository->findWithoutFail($request->get('apprenant_id'));
        $type = 'Reinscription';
        // $statut = 'Etabli';
        $statut = 'En attente';
        $inscription_status = 'RAS';
        $input = $request->all();
        $input['type'] = $type;
        $input['state'] = $statut;
        $input['inscription_status'] = $inscription_status;

        $contrat = $this->contratRepository->updateOrCreate(
            [
                'apprenant_id' => $apprenant->id,
                'academic_year_id' => $request->input('academic_year_id'),
                'ville_id' => $request->input('ville_id'),
            ],
            $input
        );

        Flash::success('Apprenant saved successfully.');

        return redirect(route('contrats.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrat $contrat)
    {
        $apprenants = $this->apprenantRepository->orderBy('id', 'desc')->paginate(3);
        $spe = $this->specialiteRepository->all();
        $c = $this->cycleRepository->all();
        $v = $this->villeRepository->all();
        
        $cycles = array();
        $specialites = array();
        $cities = array();
        $academicYears = [];
        $ay = $this->academicYearRepository->all();
        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }
        foreach($c as $cycle){
            $specialites[$cycle->label] = $cycle->specialites->pluck('title', 'id')->toArray();
        }

        foreach($c as $cycle){
            $cycles[$cycle->id] = $cycle->label. ' ' .$cycle->niveau;
        }

        foreach($v as $city){
            $cities[$city->id] = $city->nom;
        }

        return view('contrats.edit', compact('contrat', 'cycles', 'apprenants', 'specialites', 'academicYears', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContratRequest $request, Contrat $contrat)
    {

        $policy = $this->contratRepository->update($request->all(),$contrat->id);
        
        if($contrat->inscription_status == "RAS" && $policy->inscription_status != "RAS") {

            $full_name = $contrat->apprenant->prenom . ' ' . $contrat->apprenant->nom;
                        
            if(strtolower($contrat->ville->nom) == "douala") User::find(18)->notify(new SendMailStudentNotification($full_name, $contrat->id));
            else User::find(18)->notify(new SendMailStudentNotification($full_name, $contrat->id));
        }

        return redirect(route('contrats.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrat $contrat)
    {
        $this->contratRepository->delete($contrat->id);
        return redirect()->route('contrats.index');
    }
}
