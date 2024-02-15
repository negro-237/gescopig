<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicYear as AnneeAcademic;
use App\Http\Requests\CreateMedicalRequest;
//use App\Http\Requests\UpdateMedicalRequest;
use App\Models\Medical;
use App\Models\AcademicYear;
use App\Models\Apprenant;
use App\Models\Contrat;
use App\Repositories\MedicalRepository;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ApprenantRepository;
use Illuminate\Http\Request;
use Flash;;
use Response;
use Yajra\DataTables\Datatables;
use DB;
use Yajra\DataTables\Html\Builder;


class MedicalController extends AppBaseController
{
    /** @var MedicalRepository */
    private $medicalRepository;
    protected $academicRepository;
    protected $apprenantRepository;
 
    public function __construct(
        MedicalRepository $medicalRepository, 
        AcademicYearRepository $academicRepository,
        ApprenantRepository $apprenantRepository,
        Request $request)
    {
        if (request()->server("SCRIPT_NAME") !== 'artisan') {

            if ($request->route()->getName() == 'absences.store')
                $this->middleware(['permission:create absences']);
            if ($request->route()->getName() == 'absences.update')
                $this->middleware(['permission:edit absences']);
        }

        $this->medicalRepository = $medicalRepository;
        $this->academicRepository = $academicRepository;
        $this->apprenantRepository = $apprenantRepository;
    }

    /**
     * Display a listing of the Absence.
     *
     * @param Request $request
     * @return Response
     */
    public function index($student_id) {

        $student = $this->apprenantRepository->findWithoutFail($student_id);
        $medicals = $this->medicalRepository->search($student_id);
        
        return view('medicals.index', compact('medicals', 'student'));
    }

    /**
     * Show the form for creating a new Absence.
     *
     * @return Response
     */
    public function create($student_id) {
        return view('medicals.create', compact('student_id'));
    }

    /**
     * Store a newly created Absence in storage.
     *
     * @param CreateMediaclRequest $request
     *
     * @return Response
     */
    public function store(CreateMedicalRequest $request)
    {
        $input = $request->all();
        $input['academic_id'] = $this->academicRepository->currentAcademicYear()->id;

        $medical = $this->medicalRepository->create($input);

        Flash::success('Medical saved successfully.');

        return redirect(url('medicals/'.$input['student_id']));
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
        $medical = $this->medicalRepository->findWithoutFail($id);

        if (empty($medical)) {
            Flash::error('Medical not found');

            return redirect(route('medical.index'));
        }

        return view('medicals.show')->with('medical', $medical);
    }

    /**
     * Show the form for editing the specified Absence.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {

        $medical = $this->medicalRepository->findWithoutFail($id);

        if (empty($medical)) {
            Flash::error('Medical not found');

            return redirect(route('medical.index'));
        }

        return view('medicals.edit')->with('medical', $medical);
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
        $medical = $this->medicalRepository->findWithoutFail($id);

        if (empty($medical)) {
            Flash::error('Medical not found');

            return redirect(url('medicals/'.$medical->student->id));
        }
      
        $this->medicalRepository->update($request->all(), $id);

        Flash::success('Medical updated successfully.');

        return redirect(url('medicals/'.$medical->student->id));
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
        $medical = $this->medicalRepository->findWithoutFail($id);

        if (empty($medical)) {
            Flash::error('Medical not found');

            return redirect(route('medicals.index'));
        }

        $this->medicalRepository->delete($id);

        Flash::success('Medical deleted successfully.');

        return redirect(route('medicals.index'));
    }
}
