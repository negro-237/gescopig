<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Apprenant;
use App\Repositories\PaysRepository;
use App\Repositories\AcademicYearRepository;
use App\Repositories\VilleRepository;
use App\Repositories\SpecialiteRepository;
use App\Repositories\CycleRepository;
use App\Repositories\ApprenantRepository;
use App\Repositories\TutorRepository;
use App\Repositories\ContratRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Flash;
use App\Notifications\RegisterNotification;

class PreRegisterController extends Controller
{
    protected $countryRepository;
    protected $academicRepository;
    protected $villeRepository;
    protected $cycleRepository;
    protected $specialiteRepository;
    protected $apprenantRepository;
    protected $tutorRepository;
    protected $contratRepository;

    public function __construct(
        PaysRepository $countryRepository,
        AcademicYearRepository $academicYearRepository,
        VilleRepository $villeRepository,
        CycleRepository $cycleRepository,
        SpecialiteRepository $specialiteRepository,
        ApprenantRepository $apprenantRepository,
        TutorRepository $tutorRepository,
        ContratRepository $contratRepository
    ) {
        $this->countryRepository = $countryRepository;
        $this->academicRepository = $academicYearRepository;
        $this->villeRepository = $villeRepository;
        $this->cycleRepository = $cycleRepository;
        $this->specialiteRepository = $specialiteRepository;
        $this->apprenantRepository = $apprenantRepository;
        $this->tutorRepository = $tutorRepository;
        $this->contratRepository = $contratRepository;
    }

    public function registerOne(Request $request) {
       
        $student = $request->session()->get('student');
        $countries = $this->countryRepository->all()->pluck('nom', 'id');
        
        return view('students.register-one', compact('student', 'countries'));
    }

    public function postRegisterOne(Request $request) {

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'dateNaissance' => 'required|date',
            'lieuNaissance' => 'required',
            'nationalite' => 'required',
            'addresse' => 'required',
            'tel' => 'required',
            'email' => 'required|email|unique:apprenants,email',
        ]); 
        
        if(empty($request->session()->get('student'))){
            
            $request->session()->put('student', $request->all());

            $student =  $request->session()->get('student');

        } else {

            $request->session()->put('student', $request->except('_token'));

            $student = $request->session()->get('student');

        }
        
        return redirect()->route('pre-register.two');

    }
   
    public function createStepTwo(Request $request) {

        $academicYears = collect([]);

        foreach($this->academicRepository->all() as $academic) {
            $academicYears->push(['id' => $academic->id, 'name' => $academic->debut .'/'. $academic->fin]);
        }
       
        $student = $request->session()->get('student');

        return view('students.register-two', compact('student', 'academicYears'));
    }

    public function postRegisterTwo(Request $request) {

        $validatedData = $request->validate([
            'region' => 'required',
            'civilite' => 'required',
            'quartier' => 'required',
            'diplome' => 'required',
            'etablissement_provenance' => 'required',
            'situation_professionnelle' => 'required',
            'entreprise' => 'nullable',
        ]);

        $student = array_merge($request->session()->get('student'), $validatedData);

        $request->session()->put('student', $student);

        return redirect()->route('pre-register.three');
    }

    public function createStepThree(Request $request) {

        $cities = $this->villeRepository->all();
        $list_cycles = $this->cycleRepository->all();
        $cycles = [];
        
        $spe = $this->specialiteRepository->all();
        $specialites = [];

        foreach($spe as $specialite) {
            $specialites[$specialite->id] = $specialite->slug.' | '.$specialite->title;
        }

        foreach($list_cycles as $cycle) {
            $cycles[$cycle->id] = $cycle->label.' '.$cycle->niveau;
        }

        $student = $request->session()->get('student');

        return view('students.register-three', compact('cities', 'specialites', 'cycles', 'student'));
    }

    public function postRegisterThree(Request $request) {

        $validatedData = $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'cycle_id' => 'required|exists:cycles,id',
            'ville_id' => 'required|exists:villes,id'
        ]);
      
        $student = array_merge($request->session()->get('student'), $validatedData);

        $request->session()->put('student', $student);
       
        return redirect()->route('pre-register.four', compact('student'));
    }

    public function createStepFour(Request $request) {

        $student = $request->session()->get('student');

        return view('students.register-four', compact('student'));
    }

    public function postRegisterFour(Request $request) {

        $validatedData = $request->validate([
            'p_name' => 'required',
            'p_profession' => 'required',
            'p_phone' => 'required',
            'p_address' => 'required',
            'p_relation' => 'required',
            'p_fixe' => 'nullable'
        ]);

        $student = array_merge($request->session()->get('student'), $validatedData);

        $request->session()->put('student', $student);

        return redirect()->route('pre-register.five', compact('student'));
    }

    public function createStepFive(Request $request) {

        $student = $request->session()->get('student');

        return view('students.register-five', compact('student'));
    }

    public function postRegisterFive(Request $request) {
        
        $request->validate([
            'file_birth' => 'required|mimes:jpg,png,pdf|max:1024',
            'file_cni' => 'required|mimes:jpg,png,pdf|max:1024',
            'file_cni_verso' => 'required|mimes:jpg,png,pdf|max:1024',
            'file_receipt' => 'required|mimes:jpg,png,pdf|max:1024',
            'file_diploma' => 'required|mimes:jpg,png,pdf|max:1024'
        ]);

        $last_academic = $this->academicRepository->lastAcademicYear();

        $student = $request->session()->get('student');
        
        $student['academic_year_id'] = $last_academic->id;
        
        $suffixe = $last_academic->apprenants()->withTrashed()->count() == 0 ? 1 : $last_academic->apprenants()->withTrashed()->count() + 233;
        $student['matricule'] = $last_academic->fin. 'PIG'. str_pad($suffixe, 3, 0, STR_PAD_LEFT);

        return DB::transaction(function () use ($student, $request) {

            $path = 'public/uploads';

            $file_birth = $request->file('file_birth');
            $student['file_birth'] = Str::random(20) . '.' . $file_birth->getClientOriginalExtension();
            $file_birth->storeAs($path, $student['file_birth']);

            $file_cni = $request->file('file_cni');
            $student['file_cni'] = Str::random(20) . '.' . $file_cni->getClientOriginalExtension();
            $file_cni->storeAs($path, $student['file_cni']);

            $file_cni_verso = $request->file('file_cni_verso');
            $student['file_cni_verso'] = Str::random(20) . '.' . $file_cni_verso->getClientOriginalExtension();
            $file_cni_verso->storeAs($path, $student['file_cni_verso']);

            $file_receipt = $request->file('file_receipt');
            $student['file_receipt'] = Str::random(20) . '.' . $file_receipt->getClientOriginalExtension();
            $file_receipt->storeAs($path, $student['file_receipt']);

            $file_diploma = $request->file('file_diploma');
            $student['file_diploma'] = Str::random(20) . '.' . $file_diploma->getClientOriginalExtension();
            $file_diploma->storeAs($path, $student['file_diploma']);
            return $student;
            $student_save = $this->apprenantRepository->save($student);

            $this->contratRepository->firstOrCreate([
                'apprenant_id' => $student_save->id,
                'specialite_id' => $student['specialite_id'],
                'cycle_id' => $student['cycle_id'],
                'ville_id' => $student['ville_id'],
                'academic_year_id' => $student['academic_year_id'],
                'type' => 'Pre-Inscription',
                'state' => 'En attente',
                'inscription_status' => 'RAS'
            ]);

            $this->tutorRepository->create([
                'apprenant_id' => $student_save->id,
                'name'  => $student['p_name'],
                'profession'  => $student['p_profession'],
                'addresse'  => $student['p_address'],
                'tel_mobile'  => $student['p_phone'],
                'tel_fixe' => $student['p_fixe'],
                'type' => $student['p_relation'],
            ]); 

            if($student['ville_id'] === "1") User::find(8)->notify(new RegisterNotification($student));
            else if($student['ville_id'] === "2") User::find(54)->notify(new RegisterNotification($student));
            else User::find(55)->notify(new RegisterNotification($student));

        });

        $request->session()->flush();

        Flash::success('Vos Pré-inscription a bien été enregistrée, nous vous reviendrons à l\'addresse: ' . $student['email']);

        return redirect()->back();
    }
}