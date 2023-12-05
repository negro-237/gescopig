<?php

namespace App\Http\Controllers;

use App\DataTables\EnseignementDataTable;
use App\Events\EnseignementUpdate;
use App\Helpers\AcademicYear;
use App\Http\Requests;
use App\Http\Requests\CreateEnseignementRequest;
use App\Http\Requests\UpdateEnseignementRequest;
use App\Models\TroncCommun;
use App\Repositories\ContratEnseignantRepository;
use App\Repositories\CycleRepository;
use App\Repositories\EcueRepository;
use App\Repositories\EnseignantRepository;
use App\Repositories\EnseignementRepository;
use App\Repositories\SemestreRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\UeRepository;
use App\Repositories\VilleRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use PDF;
use DB;
use App\Models\Ville;
use App\Models\Enseignement;

class EnseignementController extends AppBaseController
{
    /** @var  EnseignementRepository */
    private $enseignementRepository;
    private $ecueRepository;
    private $enseignantRepository;
    private $semestreRepository;
    private $specialiteRepository;
    private $cycleRepository;
    protected $anneeAcademic;
    protected $ueRepository;
    protected $contratEnseignantRepository;
    protected $villeRepository;

    public function __construct(EnseignementRepository $enseignementRepo, AcademicYear $academicYear, ContratEnseignantRepository $contratEnseignantRepository,
                                EcueRepository $ecueRepository, EnseignantRepository $enseignantRepository,
                                SemestreRepository $semestreRepository, SpecialiteRepository $specialiteRepository,
                                CycleRepository $cycleRepository,UeRepository $ueRepository, 
                                VilleRepository $villeRepository, Request $request)
    {
        if(request()->server("SCRIPT_NAME") !== 'artisan') {
            if ($request->route()->getName() == 'enseignements.create')
                $this->middleware(['permission:create enseignements']);
            if ($request->route()->getName() == 'enseignements.affiche')
                $this->middleware(['permission:read enseignements']);
            if ($request->route()->getName() == 'enseignements.editMh')
                $this->middleware(['permission:update enseignements']);
            if ($request->route()->getName() == 'enseignements.index')
                $this->middleware(['permission:read enseignements']);
            if ($request->route()->getName() == 'enseignements.edit')
                $this->middleware(['permission:update enseignements|edit enseignements']);
            if ($request->route()->getName() == 'enseignements.update')
                $this->middleware(['permission:update enseignements|edit enseignements']);
            if ($request->route()->getName() == 'enseignements.updateMh')
                $this->middleware(['permission:update enseignements']);
        }

        $this->enseignementRepository = $enseignementRepo;
        $this->ecueRepository = $ecueRepository;
        $this->enseignantRepository = $enseignantRepository;
        $this->semestreRepository = $semestreRepository;
        $this->specialiteRepository = $specialiteRepository;
        $this->cycleRepository = $cycleRepository;
        $this->ueRepository = $ueRepository;
        $this->anneeAcademic = $academicYear->getCurrentAcademicYear();
        $this->contratEnseignantRepository = $contratEnseignantRepository;
        $this->villeRepository = $villeRepository;
    }

    /**
     * Display a listing of the Enseignement.
     *
     * @param EnseignementDataTable $enseignementDataTable
     * @return Response
     */
    public function index(EnseignementDataTable $enseignementDataTable)
    {
//        return $enseignementDataTable->render('enseignements.index');

         
        $enseignements = $this->enseignementRepository->findWhere(['academic_year_id' => $this->anneeAcademic]);
        
        /*
        $enseignements = Enseignement::where('academic_year_id', '=', $this->anneeAcademic)->where('ville_id', 1)->get();*/
//        $tc = [];
//
//        foreach ($enseignements as $enseignement){
//            if($enseignement->tronc_commun_id != null){
//                if (!in_array($enseignement->tronc_commun_id, $tc)){ // Si le tronc commun n'a pas encore été exploré on l'ajoute aux tableau de id de tc
//                    $tc[] = $enseignement->tronc_commun_id;
//                    foreach ($enseignement->tronc_commun->enseignements as $ens){ //pour chaque enseignement de ce tronc commun on affecte le meme enseignant
//                        $ens->contrat_enseignant_id = $enseignement->contrat_enseignant_id;
//                        $ens->save();
//                    }
//                }
//            }
//        }

        return view('enseignements.index', compact('enseignements'));
    }

    /**
     * Show the form for creating a new Enseignement.
     *
     * @return Response
     */
    public function create($semestre, $specialite)
    {
        $ens= $this->contratEnseignantRepository->findWhere(['academic_year_id' => $this->anneeAcademic]);
        $ue = $this->ueRepository->all();
        //Variables dans lesquelles seront sockées les ecues et les enseignants filtrés
        $ecues=$enseignants=array();

        $spe = $this->specialiteRepository->findWithoutFail($specialite);
        $ec = $spe->ecues->where('semestre_id', $semestre)->where('academic_year_id', $this->anneeAcademic);

        $ues = array();

        foreach($ue as $u){
            $ues[$u->id] = $u->title .'(' .$u->code .')';
        }

        foreach($ec as $ecue){
            if($ecue->semestre_id == $semestre){
                $ecues[$ecue->id] = $ecue->title;
            }
        }

        foreach($ens as $contrat){
            if($contrat->enseignant)
                $enseignants[$contrat->id] = $contrat->enseignant->name;
        }

        $villes = Ville::all();

        return view('enseignements.create', compact('ecues', 'enseignants', 'ues', 'specialite', 'villes'));
    }



    public function search($n, $ville_id = null) {

        $specialites = $this->specialiteRepository->all();
        $cycles = $this->cycleRepository->all();
        if($n == '1')
            $method = 'create';
        /*
        elseif($n == '2')
            $method = 'affiche';
        */
        elseif($n == '2')
            $method = 'afficheDouala';
       /*  elseif($n == '3')
            $method = 'afficheYaoundeuuu'; */
        $model = 'enseignements';

        return view('search',compact('cycles','model', 'method', 'ville_id'));
    }

    public function affiche($sem, $spe, Request $request) {
        
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $this->anneeAcademic);

        $ens = [];
        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        }
        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);
        $request->session()->forget('url');

        return view('enseignements.affiche', compact('enseignements', 'specialite', 'semestre'));

    }

    public function afficheEvolution($sem, $spe, $ville_id, Request $request) {

        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $this->anneeAcademic);

        $ville = $this->villeRepository->findWithoutFail($ville_id);

        $ens = [];
        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->where('ville_id', $ville_id)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        }

        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);
        $request->session()->forget('url');

        return view('enseignements.afficheDouala', compact('enseignements', 'specialite', 'semestre', 'ville'));

    }

    public function afficheYaounde($sem, $spe, Request $request){
        $semestre = $this->semestreRepository->findWithoutFail($sem);
        $specialite = $this->specialiteRepository->findWithoutFail($spe);
        $ecues = $specialite->ecues->where('semestre_id', $semestre->id)->where('academic_year_id', $this->anneeAcademic);

        $ens = [];
        foreach($ecues as $ec){
            $enseignement = $ec->enseignements->where('specialite_id', $specialite->id)->where('ville_id', 2)->first();
            isset($enseignement->id) ? array_push($ens, $enseignement->id) : '';
        }
        $enseignements = $this->enseignementRepository->findWhereIn('id', $ens);
        $request->session()->forget('url');

        return view('enseignements.afficheYaounde', compact('enseignements', 'specialite', 'semestre'));

    }

    public function rapport($n){
        if($n==1 || $n==2){
            $semestres = $this->semestreRepository->findWhere(['suffixe' => $n]);


            view()->share(['semestres'=>$semestres, 'anneeAcademic' => $this->anneeAcademic]);

            return view('enseignements.rapport');
        }
        else{
            return route('home');
        }

    }

    /**
     * Store a newly created Enseignement in storage.
     *
     * @param CreateEnseignementRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException 
     */
    public function store(CreateEnseignementRequest $request)
    {
        $input = $request->except(['ecue_id', 'specialite_id']);
        $input['academic_year_id'] = $this->anneeAcademic;
        //dd($input);
        //return $request->specialite_id;
        // check if enseignement already exists
        $checkEnseignementExists = $this->enseignementRepository->findWhere([
            "ville_id" => $input['ville_id'],
            "academic_year_id" => $input['academic_year_id'],
            "ecue_id" => $request->ecue_id,
            "specialite_id" => $request->specialite_id,
        ])->first();
        
        if($checkEnseignementExists) {
            return redirect()->back()->with('error', 'Cet Enseignement existe deja dans cette ville');
        }

        $ecue = $this->ecueRepository->findWithoutFail($request->input('ecue_id'));
        $tc = null;
        if($ecue->enseignements->where('contrat_enseignant_id', $input['contrat_enseignant_id'])->count() >= 1){
            if($ecue->enseignements->where('contrat_enseignant_id', $input['contrat_enseignant_id'])->first()->tronc_commun_id == null){
                $tc = TroncCommun::create()->id;
                foreach ($ecue->enseignements->where('contrat_enseignant_id', $input['contrat_enseignant_id']) as $e){
                    $e->tronc_commun_id = $tc;
                    $e->save();
                }
            }
            else
                $tc = $ecue->enseignements->where('academic_year_id', $this->anneeAcademic)->first()->tronc_commun_id;
        }
        $input['tronc_commun_id'] = $tc;
        //        dd($input);
        $enseignement = $this->enseignementRepository->updateOrCreate([
            'ecue_id' => $request->input('ecue_id'), 'specialite_id' => $request->input('specialite_id'), 'ville_id' => $request->input('ville_id')],
            $input
        );

        Flash::success('Enseignement saved successfully.');

        return redirect(route('enseignements.index'));
    }

    /**
     * Display the specified Enseignement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        
        if (empty($enseignement)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }
        /*
        $pdf = PDF::loadView('enseignements.show', compact('enseignement'));
        return $pdf->stream();
        */
        
        return view('enseignements.show')->with('enseignement', $enseignement);
    }

    // Méthode permettant d'afficher les fiches d'autorisation de paiement
    public function autorisationPaiement($id){
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        return view('enseignements.autorisation-paiement')->with('enseignement', $enseignement);
    }

    /**
     * Show the form for editing the specified Enseignement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $enseignement = $this->enseignementRepository->findWithoutFail($id);

        if($enseignement->ingoing)
            $enseignement->ingoing->delete();

        $ec = $this->ecueRepository->findWhere(['academic_year_id' => $this->anneeAcademic]);
        $spe = $this->specialiteRepository->all();
        $ens = $this->contratEnseignantRepository->findWhere(['academic_year_id' => $this->anneeAcademic]);
        $ue = $this->ueRepository->all();
        $ecues = [];
        $enseignants = [];
        foreach($ec as $ecue){
            $ecues[$ecue->id] = $ecue->title .'(' .$ecue->slug .')';
        }

        $specialite = $enseignement->specialite->id;

        $ues = array();

        foreach($ue as $u){
            $ues[$u->id] = $u->title .'(' .$u->code .')';
        }

        foreach($ens as $contrat){
            if($contrat->enseignant)
            $enseignants[$contrat->id] = $contrat->enseignant->name;
        }
        if (empty($enseignement)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }
        $villes = Ville::all();

        return view('enseignements.edit', compact('enseignement', 'ecues', 'enseignants', 'specialite', 'ues', 'villes'));
    }

    public function editMh($id){
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        if (empty($enseignement)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }

        $url = back()->getTargetUrl();
        session(['url' => $url]);

        return view('enseignements.editMh', compact('enseignement', 'url'));
    }

    public function updateMh($id, UpdateEnseignementRequest $request){

        $ens = $this->enseignementRepository->findWithoutFail($id);
        if (empty($ens)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }

        $input = $request->all();
        $mheff = (int)($ens->mhEff + $request->input('mhEff'));
        $enseignements = $ens->ecue->enseignements->where('contrat_enseignant_id', $ens->contratEnseignant->id);

        $input['mhEff'] = $mheff;
        foreach ($enseignements as $enseignement){
            $enseignement = $this->enseignementRepository->update($input, $enseignement->id);
        }

        Flash::success('Enseignement updated successfully.');

        return redirect($request->session()->get('url'));
    }

    public function pdfview(Request $requests){
        $enseignements = $this->enseignementRepository->findWhere(['academic_year_id' => $this->anneeAcademic]);
        view()->share('enseignements',$enseignements);

        if($requests->has('download')){
            $pdf = PDF::loadView('enseignements.pdfView');
            return $pdf->download('enseignementList.pdf');
        }
        return view('enseignements.pdfView');
    }

    /**
     * Update the specified Enseignement in storage.
     *
     * @param  int              $id
     * @param UpdateEnseignementRequest $request
     *
     * @return Response
     */
    public function update($id, CreateEnseignementRequest $request)
    {
        $enseignement = $this->enseignementRepository->findWithoutFail($id);
        $input = $request->except('specialite_id');

        if (empty($enseignement)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }
        
//        $enseignement = $this->enseignementRepository->update($input, $id);

        /**
         * Si l'enseignement est un tronc commun on modifie tout les enseignement reliés au tronc commun
         * Si non on modifie uniquement l'enseignement
         */
//        if ($enseignement->tronc_commun_id != null){
//            foreach ($enseignement->tronc_commun->enseignements as $ens){
//                $this->enseignementRepository->update($input, $ens->id);
//            }
//        }
//        else{
//        }
        $enseignement = $this->enseignementRepository->update($input, $id);

        /** On verifie que tous les enseignements ayant le meme ecue et le même enseignant possede le meme id de tronc commun */
        $ecue = $enseignement->ecue;
        if ($ecue->enseignements->where('contrat_enseignant_id', $enseignement->contratEnseignant->id)->count() > 1){

            // Si l'enseignement possède un id de tronc commun on affecte celui ci à tous les tronc enseignement ayant
            // le meme enseignant et le meme ecue

            $enstc = ($enseignement->tronc_commun_id != null) ? $enseignement : $ecue->enseignements->where('tronc_commun_id', '!=', null)->first(); // On recupere le premier id de tronc commun

            $tc = ($enstc != null) ? $enstc->tronc_commun->id : TroncCommun::create()->id;

            foreach ($ecue->enseignements->where('contrat_enseignant_id', $enseignement->contratEnseignant->id) as $e){
                $e->tronc_commun_id = $tc;
                $e->save();
            }

        }

        // si non mettre tronc commun id =0


        Flash::success('Enseignement updated successfully.');

        return redirect(route('enseignements.index'));
    }

    /**
     * Remove the specified Enseignement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $enseignement = $this->enseignementRepository->findWithoutFail($id);

        if (empty($enseignement)) {
            Flash::error('Enseignement not found');

            return redirect(route('enseignements.index'));
        }

        $this->enseignementRepository->delete($id);

        Flash::success('Enseignement deleted successfully.');

        return redirect(route('enseignements.index'));
    }
}
