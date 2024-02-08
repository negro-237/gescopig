<?php

namespace App\Http\Controllers;

use App\Repositories\PaysRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class PaysController extends Controller
{
    protected $paysRepository;

    public function __construct(PaysRepository $paysRepository)
    {
        $this->paysRepository = $paysRepository;
    }

    /**
     * Afficher la liste des pays.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pays = $this->paysRepository->all();

        return view('pays.index', compact('pays'));
    }

    /**
     * Afficher le formulaire de création des pays
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pays.create');
    }

    /**
     * Enregistrer un nouveau pays
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:pays,nom',
            'code' => 'required|unique:pays,code'
        ]);

        $input = $request->all();

        $pays = $this->paysRepository->create($input);

        Flash::success('Le pays ' . $pays->nom . ' a été créé avec succès');

        return redirect(route('pays.index'));
    }

    /**
     * Afficher les informations sur un pays
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Afficher le formulaire permettant de modifier un pays.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pays = $this->paysRepository->find($id);
        if (empty($pays)) {
            Flash::error('Ce pays n\'existe plus en base de données');

            return redirect(route('pays.index'));
        }
        return view('pays.edit', compact('pays'));
    }

    /**
     * Modifier un pays
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pays = $this->paysRepository->find($id);
        if (empty($pays)) {
            Flash::error('Ce pays n\'existe plus en base de données');

            return redirect(route('pays.index'));
        }

        $pays = $this->paysRepository->update($request->all(), $id);

        Flash::success('Ce pays a été mis à jour avec succès.');

        return redirect(route('pays.index'));
    }

    /**
     * Supprimer un pays
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pays = $this->paysRepository->find($id);
        if (empty($pays)) {
            Flash::error('Ce pays n\'existe plus en base de données');

            return redirect(route('pays.index'));
        }

        $paysName = $pays->nom;
        $pays = $this->paysRepository->delete($id);

        Flash::success('Le pays "' . $paysName . '" a été supprimé avec succès.');

        return redirect(route('pays.index'));
    }
}
