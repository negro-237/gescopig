<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApprenantRepository;
use App\Repositories\AcademicYearRepository;

class HomeController extends Controller
{
    private $apprenantRepository;
    protected $academicYearRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApprenantRepository $apprenantRepository, AcademicYearRepository $academicYearRepository)
    {
        $this->middleware('auth');
        $this->apprenantRepository = $apprenantRepository;
        $this->academicYearRepository = $academicYearRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('student')) {

            if(auth()->user()->state === 0) {
                return redirect()->route('user.password-reset');
            }

            $current_academic = $this->academicYearRepository->findWhere(['actif' => true])->first();

            $student = $this->apprenantRepository->findWhere(['email' => auth()->user()->email])->first();
            
            $absences =  $student->contrats->where('academic_year_id', $current_academic->id)->first()->absences->where('justify', false)->count();
            
            $account = $student->contrats->where('academic_year_id', $current_academic->id)->first()->cycle->echeanciers->where('academic_year_id', $current_academic->id)->sum('montant');
            
            $amount =  $student->contrats->where('academic_year_id', $current_academic->id)->first()->versements->sum('montant');

            $corkage_amount =  - $student->contrats->where('academic_year_id', $current_academic->id)->first()->corkages->where('reduction', true)->sum('montant');
            
            return view('home', compact('absences', 'account', 'amount', 'corkage_amount'));
        } 

        return view('home');
    }
}
