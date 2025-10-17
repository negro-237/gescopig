<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicYear;
use App\Http\Requests\CreateApprenantRequest;
use App\Http\Requests\UpdateApprenantRequest;

use App\Models\Apprenant;
use App\Models\Tutor;
use App\Models\Ville;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ApprenantRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ContratRepository;
use App\Repositories\CycleRepository;
use App\Repositories\ScolariteRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\VilleRepository;
use App\Repositories\PaysRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Notifications\SendMailNotification;
use App\User;
use App\Models\AcademicYear as AcademicYearModel;

class ApprenantController extends AppBaseController
{
    /** @var  ApprenantRepository */
    private $apprenantRepository;
    protected $specialiteRepository;
    protected $cycleRepository;
    protected $scolariteRepository;
    protected $academicYear;
    protected $contratRepository;
    protected $academicYearRepository;
    protected $villeRepository;
    protected $countryRepository;

    public function __construct(ApprenantRepository $apprenantRepo, SpecialiteRepository $specialiteRepository, ContratRepository $contratRepository,PaysRepository $countryRepository,
                                CycleRepository $cycleRepository, AcademicYearRepository $academicYearRepository, ScolariteRepository $scolariteRepository, AcademicYear $academicYear, VilleRepository $villeRepository)
    {
        $this->apprenantRepository = $apprenantRepo;
        $this->specialiteRepository = $specialiteRepository;
        $this->cycleRepository = $cycleRepository;
        $this->scolariteRepository = $scolariteRepository;
        $this->contratRepository = $contratRepository;
        $this->academicYear = $academicYear->getCurrentAcademicYear();
        $this->academicYearRepository = $academicYearRepository;
        $this->villeRepository = $villeRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * Display a listing of the Apprenant.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->apprenantRepository->pushCriteria(new RequestCriteria($request));
        $apprenants = $this->apprenantRepository->all();
        //$apprenants = Apprenant::latest()->take(20)->get();
        return view('apprenants.index')
            ->with('apprenants', $apprenants);
    }

    /**
     * Show the form for creating a new Apprenant.
     *
     * @return Response
     */
    public function create()
    {
        $spe = $this->specialiteRepository->all();
        $c = $this->cycleRepository->all();
        $v = $this->villeRepository->all();
        $p_countries = $this->countryRepository->all();

        $cycles = array();
        $specialites = array();
        $villes = array();
        $countries = array();

        $academicYears = [];
        $ay = $this->academicYearRepository->all();

        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }

        foreach($spe as $specialite){
            $specialites[$specialite->id] = $specialite->slug.' | '.$specialite->title;
        }
        foreach($c as $cycle){
            $cycles[$cycle->id] = $cycle->label.' '.$cycle->niveau;
        }

        foreach($v as $ville){
            $villes[$ville->id] = $ville->nom;
        }

        foreach($p_countries as $country){
            $countries[$country->id] = strtoupper($country->nom);
        }

        return view('apprenants.create', compact('specialites', 'cycles', 'academicYears', 'villes', 'countries'));
    }

    /**
     * Store a newly created Apprenant in storage.
     *
     * @param CreateApprenantRequest $request
     *
     * @return Response
     */
    public function store(CreateApprenantRequest $request)
    {
        
        if(!empty($this->apprenantRepository->findWhere(['nom' => $request->input('nom'), 'prenom' => $request->input('prenom'), 'dateNaissance' => $request->input('dateNaissance')])->first())){
            Flash::error('Apprenant existe deja en base de données ');
            return redirect()->route('apprenants.index');
        }

        /*$inscrip = AcademicYearModel::find($request->input('academic_year_id'));
        $inscrip->apprenants()->withTrashed()->count();
        $suffixe = $inscrip->apprenants()->withTrashed()->count() + 88;
        return str_pad($suffixe,3,0,STR_PAD_LEFT);
        return $matricule = $inscrip->fin. 'PIG'. str_pad($suffixe,3,0,STR_PAD_LEFT);*/
        
        $apprenant = $this->apprenantRepository->store($request);
        $academicYear = $request->input(['academic_year_id']);

        $contrat = $this->contratRepository->firstOrCreate([
            'apprenant_id' => $apprenant->id,
            'specialite_id' => $request->input('specialite_id'),
            'cycle_id' => $request->input('cycle_id'),
            'ville_id' => $request->input('ville_id'),
            'academic_year_id' => $academicYear,
            'type' => 'Inscription',
            'state' => 'En attente',
            'inscription_status' => 'RAS'
        ]);
//        $contrat->type = 'Inscription';
//        $contrat->state = 'En attente';
//        $contrat->save();

//        dd($contrat);

        Flash::success('Apprenant saved successfully.');

        //User::find(18)->notify(new SendMailNotification);
        //User::find(6)->notify(new SendMailNotification);
        //User::find(11)->notify(new SendMailNotification);
        //User::find(29)->notify(new SendMailNotification);
        //User::find(33)->notify(new SendMailNotification);
        //User::find(38)->notify(new SendMailNotification);
        //User::find(22)->notify(new SendMailNotification);

        return redirect(route('apprenants.index'));
    }

    /**
     * Display the specified Apprenant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $apprenant = $this->apprenantRepository->findWithoutFail($id);

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }
        $a = Apprenant::with('contrats')->where('id', $id)->first();
        //dd($a);
        //return view('apprenants.show')->with('apprenant', $apprenant);

        return view('apprenants.show', compact('apprenant', 'a'));
    }

    /**
     * Show the form for editing the specified Apprenant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Apprenant $apprenant)
    {
        $academicYears = [];
        $countries = array();
        $ay = $this->academicYearRepository->all();
        $p_countries = $this->countryRepository->all();

        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        foreach($p_countries as $country){
            $countries[$country->id] = strtoupper($country->nom);
        }

        return view('apprenants.edit', compact('apprenant', 'academicYears', 'countries'));
    }

    /**
     * Update the specified Apprenant in storage.
     *
     * @param  int              $id
     * @param UpdateApprenantRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprenantRequest $request)
    {
        $apprenant = $this->apprenantRepository->findWithoutFail($id);

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        $apprenant = $this->apprenantRepository->update($request->all(), $id);

        Flash::success('Apprenant updated successfully.');

        return redirect(route('apprenants.index'));
    }

    /**
     * Remove the specified Apprenant from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $apprenant = $this->apprenantRepository->findWithoutFail($id);

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        foreach ($apprenant->contrats as $contrat){
            $this->contratRepository->delete($contrat->id);
        }

        $this->apprenantRepository->delete($id);

        Flash::success('Apprenant deleted successfully.');

        return redirect(route('apprenants.index'));
    }

    // Voir la fiche médicale d'un apprenant
    public function ficheMedicale($id){

        $apprenant = $this->apprenantRepository->findWithoutFail($id);

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }
        $a = Apprenant::with('contrats')->where('id', $id)->first();

        return view('apprenants.fiche-medicale', compact('apprenant', 'a'));
    }

    // Fonction qui retourne le formulaire d'édition de la fiche médicale
    public function editerMedicalFile(Apprenant $apprenant)
    {
        $academicYears = [];
        $ay = $this->academicYearRepository->all();
        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        return view('apprenants.edit-medical-file', compact('apprenant', 'academicYears'));
    }

    // Fonction qui permet de modifier la fiche médicale
    public function updateMedicalFile($id)
    {
        $apprenant = $this->apprenantRepository->findWithoutFail($id);

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        $apprenant = $this->apprenantRepository->update($request->all(), $id);

        Flash::success('Apprenant updated successfully.');

        return redirect(route('apprenants.index'));
    }
}
