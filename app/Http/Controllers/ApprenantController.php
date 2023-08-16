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
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Notifications\SendMailNotification;
use App\User;

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

    public function __construct(ApprenantRepository $apprenantRepo, SpecialiteRepository $specialiteRepository, ContratRepository $contratRepository,
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

        $cycles = array();
        $specialites = array();
        $villes = array();

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

        return view('apprenants.create', compact('specialites', 'cycles', 'academicYears', 'villes'));
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
        
        if(!empty($this->apprenantRepository->findWhere(['nom'=>$request->input('nom'), 'prenom'=>$request->input('prenom'), 'dateNaissance'=> $request->input('dateNaissance')])->first())){
            Flash::error('Apprenant existe deja en base de données ');
            return redirect()->route('apprenants.index');
        }
        
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
        $ay = $this->academicYearRepository->all();
        foreach ($ay as $a){
            $academicYears[$a->id] = $a->debut.'/'.$a->fin;
        }

        if (empty($apprenant)) {
            Flash::error('Apprenant not found');

            return redirect(route('apprenants.index'));
        }

        return view('apprenants.edit', compact('apprenant', 'academicYears'));
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
