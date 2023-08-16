<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicYear;
use App\Models\Contrat;
use App\Repositories\ContratRepository;
use App\Repositories\CycleRepository;
use App\Repositories\ResultatNominatifRepository;
use Illuminate\Http\Request;

class ResultatNominatifController extends Controller
{
    protected $resultatNominatifRepository;
    protected $cycleRepository;
    protected $contratRepository;
    protected $academicYear;

    public function __construct(ResultatNominatifRepository $resultatNominatifRepository, AcademicYear $academicYear,
                                CycleRepository $cycleRepository, ContratRepository $contratRepository)
    {
        $this->contratRepository = $contratRepository;
        $this->cycleRepository = $cycleRepository;
        $this->resultatNominatifRepository = $resultatNominatifRepository;
        $this->academicYear = $academicYear::getCurrentAcademicYear();
    }

    public function search($n){
//        $specialites = $this->specialiteRepository->all();
        $cycles = $this->cycleRepository->all();
        if($n == '1')
            $method = 'create';
        elseif($n == '2')
            $method = 'affiche';
        $model = 'resultatNominatifs';

        return view('search',compact('cycles','model', 'method'));
    }

    public function create($specialite, $cycle){
        $academicYear = $this->academicYear;
        $contrats = Contrat::where([
            ['specialite_id', '=', $specialite],
            ['cycle_id', '=', $cycle],
            ['contrats.academic_year_id', '=', $academicYear]
        ])->join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get();
        return view('resultatNominatifs.create', compact('contrats'));
    }

    public function store(Request $request){
        foreach($request->except('_token') as $id => $value){
            $contrat = $this->contratRepository->findWithoutFail($id);
            $resultat = $this->resultatNominatifRepository->firstOrNew(['contrat_id' => $contrat->id]);
            if ($value){
                $decision = ($value == 1)? 'Admis' : 'Admis par enjambement';
                if ($contrat->cycle_id < 5 || $contrat->cycle_id == 6){
                    $resultat->next_cycle_id = $next_cycle = $contrat->cycle_id + 1;
                    $resultat->decision = $decision.' en ' .(($next_cycle <=3 || $next_cycle == 4 || $next_cycle ==6) ? $contrat->specialite->slug : 'Master') .$this->cycleRepository->findWithoutFail($next_cycle)->niveau;
                }
                else{
                    $resultat->next_cycle_id = 0;
                    $resultat->decision = 'Valide Son Master';
                }
            }
            else{
                $resultat->next_cycle_id = $contrat->cycle_id;
                $resultat->decision = 'Redouble';
            }
            $resultat->save();
        }

        return redirect()->route('resultatNominatifs.search', 1);
    }

    public function affiche($specialite, $cycle){ // Ajouter l'année académique en cours à la fonction
        $academicYear = 3;
        
        $cycle = $this->cycleRepository->findWithoutFail($cycle);
        $contrats = Contrat::where([
            ['specialite_id', '=', $specialite],
            ['cycle_id', '=', $cycle->id],
            ['contrats.academic_year_id', '=', $academicYear]
        ])->join('apprenants', 'apprenant_id', '=', 'apprenants.id')
            ->select('contrats.*')
            ->orderBy('apprenants.nom')
            ->orderBy('apprenants.prenom')
            ->get();
        // dd($contrats);

        if ($cycle->niveau == 1) {
            // dd(1);
            foreach($contrats as $contrat){
                $resultat = $this->resultatNominatifRepository->firstOrNew(['contrat_id' => $contrat->id]);
                if ($contrat->semestre_infos->where('creditObt', 30)->count() == 2) {
                    $resultat->decision = "Admis";
                    $resultat->next_cycle_id = $cycle->id + 1;
                }
                elseif($contrat->semestre_infos->sum('creditObt') >= 45 && (($contrat->semestre_infos->where('creditObt', '>=', 15)->count() && $contrat->semestre_infos->where('creditObt', '==', 30)->count()) || $contrat->semestre_infos->where('creditObt', '>=', 22.5)->count() == 2)){
                    $resultat->decision = "Admis par enjambement";
                    $resultat->next_cycle_id = $cycle->id + 1;
                }
                else{
                    $resultat->decision = "Redouble";
                    $resultat->next_cycle_id = $cycle->id;
                }
                $resultat->save();
            }
        }
        elseif ($cycle->niveau == 2 && $cycle->label == "Licence") {
            // dd(2);
            foreach ($contrats as $contrat) {
                $apprenant = $contrat->apprenant;
                $semestreInfos = $apprenant->semestre_infos->where('contrat_id', '<=', $contrat->id);

                if($apprenant->semestre_infos->count() >= 4){
                    $resultat = $this->resultatNominatifRepository->firstOrNew(['contrat_id' => $contrat->id]);

                    if ($semestreInfos->sum('creditObt') == 120) {
                        $resultat->decision = "Admis";
                        $resultat->next_cycle_id = $cycle->id + 1;
                    }
                    elseif ($semestreInfos->sum('creditObt') >= 90 && $semestreInfos->where('creditObt', 30)->count() >=2 && $semestreInfos->where('creditObt', '>=', 15)->count() >=2) {
                        
                        $resultat->decision = "Admis par enjambement";
                        $resultat->next_cycle_id = $cycle->id + 1;
                        
                    }
                    else{
                        $resultat->decision = "Redouble";
                        $resultat->next_cycle_id = $cycle->id;
                    }

                    $resultat->save();
                    // dd($contrat->resultatNominatifs->first());
                }
                else{
                    foreach($contrats as $contrat){
                        if(($contrat->semestre_infos->sum('creditObt') + 60) >= 90 && $contrat->semestre_infos->where('creditObt', '>=', 15)->count() >= 1){
                            
                            $resultat->decision = "Admis par enjambement";
                            $resultat->next_cycle_id = $cycle->id + 1;
                        }
                    }
                       
                }
            }
        }
        elseif ($cycle->niveau == 3 || ($cycle->niveau == 2 && $cycle->label == "Master")) {
            // dd($contrats);
            foreach($contrats as $contrat){
                $apprenant = $contrat->apprenant;
                // dd($apprenant->semestre_infos);

                if (($cycle->niveau == 3 && $apprenant->semestre_infos->count() >= 5) || ($cycle->niveau == 2 && $cycle->label == "Master" && $apprenant->semestre_infos->count() >= 3) ) {

                    $resultat = $this->resultatNominatifRepository->firstOrNew(['contrat_id' => $contrat->id]);
                    
                    if ($apprenant->semestre_infos->where('creditObt', '<', 30)->count() == 0) {
                        $resultat->decision = "Admis";
                        $resultat->next_cycle_id = $cycle->id;
                    }
                    else{
                        $resultat->decision = "Redouble";
                        $resultat->next_cycle_id = $cycle->id;
                    }
                    $resultat->save();
                }
            }
        }

        return view("resultatNominatifs.affiche", compact('contrats', 'cycle'));
    }
}
