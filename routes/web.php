<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::prefix('admin')->namespace('Back')->group(function () { 
    Route::name('admin')->get('/', 'AdminController@index');
});
Route::get('/test', function() {
    return date('Y');
    return app_path();
    $users = App\User::with('roles')->get();
    $data = [];
    foreach($users as $user) {
        foreach($user->roles as $role) {
            $item = [
                'nom' => $user->name,
                'role' => $role->name,
                'permission' => $role->permissions->pluck('name'),
            ];
            array_push($data, $item);
            
        }
       
    }
    return $data;
});
Route::prefix('')->middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('home', 'HomeController@index');
    Route::get('absences/updateJustif/{justification}/{absence}', ['middleware' => 'permission:edit absences', 'uses' => 'AbsenceController@justif'])->name('absences.updateJustif');

    Route::get('absences/updateJustif/{justification}/{absence}', ['middleware' => 'permission:edit absences', 'uses' => 'AbsenceController@updateJustif'])->name('absences.updateJustif');

    Route::get('absences/search/{n}/{ville_id}', ['middleware' => 'permission:create absences|read absences|read enseignements', 'uses' => 'AbsenceController@search'])->name('absences.search');
    Route::get('absences/etat', 'AbsenceController@etat')->name('absences.etat');

    Route::get('absences/affiche/{semestre}/{specialite}', ['middleware' => 'permission:read absences', 'uses' => 'AbsenceController@affiche'])->name('absences.affiche');

    Route::get('absences/affiche-absence/{semestre}/{specialite}/{ville_id}', ['middleware' => 'permission:read absences', 'uses' => 'AbsenceController@afficheAbsence'])->name('absences.afficheAbsence');

    Route::get('absences/afficheYaounde/{semestre}/{specialite}', ['middleware' => 'permission:read absences', 'uses' => 'AbsenceController@afficheYaounde'])->name('absences.afficheYaounde');

    Route::get('absences/create/{semestre}/{specialite}', ['middleware' => 'permission:create absences', 'uses' => 'AbsenceController@create'])->name('absences.create');

    Route::get('absences/create-absence/{semestre}/{specialite}/{ville_id}', ['middleware' => 'permission:create absences', 'uses' => 'AbsenceController@createAbsence'])->name('absences.createAbsence');

    Route::get('absences/createYaounde/{semestre}/{specialite}', ['middleware' => 'permission:create absences', 'uses' => 'AbsenceController@createYaounde'])->name('absences.createYaounde');

    Route::get('absences/fiche/{semestre}/{specialite}/{ville_id}', 'AbsenceController@ficheAbsence')->name('absences.ficheAbsence');

    Route::get('absences/fiche-presence/{semestre}/{specialite}/{id}/{ville_id}', 'AbsenceController@ficheEcue')->name('absences.fiche-ecue');

    Route::get('absences/ficheYaounde/{semestre}/{specialite}', 'AbsenceController@ficheYaounde')->name('absences.ficheYaounde');

    Route::get('absences/ficheYaounde/{semestre}/{specialite}/{id}', 'AbsenceController@ficheEcueYaounde')->name('absences.fiche-ecue-yaounde');

    Route::get('absences/{apprenant}/edit/{semestre}', ['middleware' => 'permission:read absences', 'uses' => 'AbsenceController@edit'])->name('absences.edit');

    //    Route::get('absence/afficheData, AbsenceController@afficheData')->name('absences.afficheData');
    Route::resource('absences', 'AbsenceController')->except('create', 'edit', 'show');

    Route::name('specialites.getData')->get('specialites/getData', 'SpecialiteController@getData');

    Route::resource('semestres', 'SemestreController');

    Route::get('contrats/all', 'ContratController@all')->name('contrats.all');
    Route::get('contrats/awaiting', 'ContratController@awaiting')->name('contrats.awaiting');
    Route::get('contrats/awaiting-return', 'ContratController@awaitingReturn')->name('contrats.awaiting-return');
    Route::get('contrats/returned', 'ContratController@returned')->name('contrats.returned');
    Route::get('contrats/learner', 'ContratController@learner')->name('contrats.learner');
    Route::get('contrats/registered-learner', 'ContratController@registeredLearner')->name('contrats.registered-learner');
    Route::get('contrats/registered-learner-with-moratorium', 'ContratController@registeredLearnerWithMoratorium')->name('contrats.registered-learner-with-moratorium');

    Route::resource('contrats', 'ContratController');

    Route::get('ecues/{id}/getEcues', 'EcueController@getEcues');
    Route::resource('ecues', 'EcueController');

    Route::resource('cycles', 'CycleController');

    Route::resource('apprenants', 'ApprenantController');

    Route::resource('specialites', 'SpecialiteController');

    Route::resource('enseignants', 'EnseignantController');

    Route::get('tutors/{id}', 'TutorController@index')->name('tutors.index');
    Route::get('tutors/create/{id}', 'TutorController@create')->name('tutors.create');
    Route::post('tutors/{id}', 'TutorController@store')->name('tutors.store');
    Route::resource('tutors', 'TutorController')->only('edit', 'update', 'destroy');

    Route::resource('enseignements', 'EnseignementController')->except('create');
    Route::get('enseignements/affiche/{semestre}/{specialite}', 'EnseignementController@affiche')->name('enseignements.affiche');
    Route::get('enseignements/affiche-evolution/{semestre}/{specialite}/{ville_id}', 'EnseignementController@afficheEvolution')->name('enseignements.afficheDouala');
    Route::get('enseignements/afficheYaounde/{semestre}/{specialite}', 'EnseignementController@afficheYaounde')->name('enseignements.afficheYaounde');

    Route::get('enseignements/search/{n}/{ville_id?}', 'EnseignementController@search')->name('enseignements.search');
    Route::patch('enseignements/{specialites}/updateMh', 'EnseignementController@updateMh')->name('enseignements.updateMh');
    Route::get('enseignements/{specialite}/editMh', 'EnseignementController@editMh')->name('enseignements.editMh');
    Route::get('enseignements/create/{semestre}/{specialite}', 'EnseignementController@create')->name('enseignements.create');
    Route::get('enseignements/rapport/{n}', 'EnseignementController@rapport')->name('rapport');

    // Afficher les fiches d'autorisation de paiement
    Route::get('enseignements/autorisation-paiement/{id}', 'EnseignementController@autorisationPaiement')->name('enseignements.autorisation-paiement');

    //    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');

    // Route permettant d'afficher le formulaire de modification du mot de passe
    Route::get('user/password','UserController@password')->name('user.password');
    // Route permettant de sauvegarder le nouveau mot de passe
    Route::post('user/password','UserController@changePassword')->name('user.password');

    Route::get('absences/test', 'AbsenceController@test');

    Route::resource('catUes', 'CatUeController')->except('show');
    Route::resource('ues', 'UeController')->except('show');

    Route::get('notes/locked/{session}/{academic_year}/{level}', 'NoteController@lock_notes')->name('notes.locked');
    Route::get('notes/lock', 'NoteController@getDataForLockNotes');
    Route::get('notes/search/{n}/{type?}/{ville_id?}', 'NoteController@search')->name('notes.search');
    // Routes pour l'enregistrement des notes
    Route::get('notes/affiche/{semestre}/{specialite}', 'NoteController@affiche')->name('notes.affiche');
    Route::get('notes/afficheNotes/{semestre}/{specialite}/{ville_id}', 'NoteController@afficheNotes')->name('notes.afficheNotes');
    //Route::get('notes/afficheNotesYaounde/{semestre}/{specialite}/{ville_id}', 'NoteController@afficheNotesYaounde')->name('notes.afficheNotesYaounde');

    Route::get('notes/imprime/{semestre}/{specialite}', 'NoteController@imprime')->name('notes.imprime');
    Route::get('notes/releve/{session}/{contrat}/{semestre}', 'NoteController@releve')->name('notes.releve');
    Route::get('notes/pv/{specialite}/{semestre}/{type?}', 'NoteController@a_deliberer')->name('notes.a_deliberer');
    Route::post('notes/pv/{specialite}/{semestre}/{type?}', 'NoteController@pv')->name('notes.pv');

    Route::get('notes/pvcc/{specialite}/{semestre}/{ville_id?}', 'NoteController@pvcc')->name('notes.pvcc');
    Route::get('notes/pvccDla/{specialite}/{semestre}', 'NoteController@pvcc_dla')->name('notes.pvcc_dla');
    Route::get('notes/pvccYde/{specialite}/{semestre}', 'NoteController@pvcc_yde')->name('notes.pvcc_yde');

    Route::get('notes/rn_intermediaire/{specialite}/{semestre}/{ville_id}/{type?}', 'NoteController@rn_intermediaire')->name('notes.rn_intermediaire');
    Route::get('notes/rn_intermediaireDouala/{specialite}/{semestre}/{type?}', 'NoteController@rn_intermediaireDouala')->name('notes.rn_intermediaireDouala');
    Route::get('notes/rn_intermediaireYaounde/{specialite}/{semestre}/{type?}', 'NoteController@rn_intermediaireYaounde')->name('notes.rn_intermediaireYaounde');

    Route::resource('notes', 'NoteController')->except('store', 'show');

    Route::get('notes/show/{type}/{id}', 'NoteController@show')->name('notes.show');
    Route::get('notes/show-notes/{type}/{id}/{ville_id}', 'NoteController@showNotes')->name('notes.show-notes');
    Route::get('notes/showYaounde/{type}/{id}', 'NoteController@showYaounde')->name('notes.showYaounde');
    
    Route::post('notes/{type}/{enseignement}', 'NoteController@store')->name('notes.store');
    // Enregistrer les notes de Douala
    Route::post('notes1/{type}/{enseignement}', 'NoteController@storeDouala')->name('notes.storeDouala');
    // Enregistrer les notes de Yaoundé
    Route::post('notes2/{type}/{enseignement}', 'NoteController@storeYaounde')->name('notes.storeYaounde');

    

    Route::get('notes/deliberation/{semestre}/{specialite}', 'NoteController@deliberation')->name('notes.deliberation');
    Route::get('notes/notesDeliberation/{type}/{contrat}/{semestre}', 'NoteController@noteDeliberation')->name('notes.noteDeliberation');
    // Enregistrer la note de délibération
    Route::post('notes/deliberation/{semestre}/{type}/{contrat}', 'NoteController@saveDeliberation')->name('notes.saveDeliberation');
    /*
        Séparer les notes de délibération de Douala et Yaoundé
        Route::get('notes/deliberationDouala/{semestre}/{specialite}', 'NoteController@deliberationDouala')->name('notes.deliberationDouala');
        Route::get('notes/notesDeliberationDouala/{type}/{contrat}/{semestre}', 'NoteController@noteDeliberationDouala')->name('notes.noteDeliberationDouala');

        Route::get('notes/deliberationYaounde/{semestre}/{specialite}', 'NoteController@deliberationYaounde')->name('notes.deliberationYaounde');
        Route::get('notes/notesDeliberationYaounde/{type}/{contrat}/{semestre}', 'NoteController@noteDeliberationYaounde')->name('notes.noteDeliberationYaounde');
    */

    Route::get('notes/getNoteContrat/{contrat}/{enseignement}', 'NoteController@getNoteContrat')->name('notes.getNoteContrat');

    // Etudiants en deuxième session
    Route::get('notes/rattrapage/{semestre}/{specialite}/{ville_id}', 'NoteController@rattrapage')->name('notes.rattrapage');
    //Route::get('notes/rattrapageDLA/{semestre}/{specialite}', 'NoteController@rattrapageDLA')->name('notes.rattrapageDLA');
   // Route::get('notes/rattrapageYDE/{semestre}/{specialite}', 'NoteController@rattrapageYDE')->name('notes.rattrapageYDE');

    // Routes fiche de notation
    Route::get('notes/fiche/{semestre}/{specialite}/{ville_id}', 'NoteController@fiche')->name('notes.fiche');
    Route::get('notes/fiche/{semestre}/{specialite}/{id}/{ville_id}', 'NoteController@ficheNotationCC')->name('notes.fiche-notation');

    // Routes fiche de notation Yaoundé
   /*  Route::get('notes/ficheYaounde/{semestre}/{specialite}', 'NoteController@ficheYaounde')->name('notes.ficheYaounde');
    Route::get('notes/ficheYaounde/{semestre}/{specialite}/{id}', 'NoteController@ficheNotationCCYaounde')->name('notes.fiche-notation-yaounde'); */

    Route::get('versements/listeApprenants', 'VersementController@listeApprenants')->name('versements.listeApprenants');
    Route::get('versements/etats', 'VersementController@etats')->name('versements.etats');
    Route::get('versements/details/{id}', 'VersementController@details')->name('versements.details');
    Route::post('versements/{id}', 'VersementController@store')->name('versements.store');
    Route::get('versements/show/{id}', 'VersementController@show')->name('versements.show');
    Route::get('versements/{id}/edit', 'VersementController@edit')->name('versements.edit');
    Route::patch('versements/{id}/update', 'VersementController@update')->name('versements.update');
    Route::delete('versements/destroy/{id}', 'VersementController@destroy')->name('versements.destroy');


    Route::resource('echeanciers', 'EcheancierController');

    Route::get('moratoires/create/{id}', 'MoratoireController@create')->name('moratoires.create');
    Route::post('moratoires/{id}', 'MoratoireController@store')->name('moratoires.store');
    Route::get('moratoires', 'MoratoireController@index')->name('moratoires.index');
    Route::get('moratoires/{id}/edit', 'MoratoireController@edit')->name('moratoires.edit');
    Route::patch('moratoires/{id}', 'MoratoireController@update')->name('moratoires.update');

    Route::get('scolarites', 'ScolariteController@index')->name('scolarites.index');
    Route::get('scolarites/old', 'ScolariteController@old')->name('scolarites.old');
    Route::get('scolarites/inscrits', 'ScolariteController@inscrits')->name('scolarites.inscrits');
    Route::post('scolarites/filter', 'ScolariteController@filter')->name('scolarites.filter');

    Route::get('rnr', function () {
        return view('notes.rnr_imprime');
    });
    Route::get('certificat/{type}', function ($type) {
        return view('documents.certificat')->with(['type' => $type]);
    }); 
    Route::get('scolarites/contrats/{id}', 'ScolariteController@contrats')->name('scolarites.contrat');
    Route::get('scolarites/attestation/{contrat}/{type}', 'ScolariteController@attestation')->name('scolarites.attestation');
    Route::get('scolarites/certificat/{contrat}/{type}', 'ScolariteController@certificat')->name('scolarites.certificat');
    Route::get('scolarites/autorisation/{id}', 'ScolariteController@autorisation')->name('scolarites.autorisation');
    Route::get('scolarites/suspension/{id}', 'ScolariteController@suspension')->name('scolarites.suspension');
    Route::get('scolarites/printSuspension', 'ScolariteController@printSuspension')->name('scolarites.printSuspension');
    Route::post('scolarites/printSuspension', 'ScolariteController@suspensions')->name('scolarites.suspensions');

    Route::get('scolarites/attestations/search/{n}', 'ScolariteController@search')->name('scolarites.search'); // pour selectionner la classe a imprimer
    Route::get('scolarites/attestations/select/{cycle}/{specialite}', 'ScolariteController@select_admis')->name('scolarites.select_admis');
    Route::post('scolarites/attestations_reussite', 'ScolariteController@attestations_reussite')->name('scolarites.attestations_reussite');

    // Rechercher les diplômés de licence
    Route::get('scolarites/diplomes/licence/{n}', 'ScolariteController@licence')->name('scolarites.licence');
    // Sélectionner la classe de licence à imprimer
    Route::get('scolarites/diplomes/select-licence/{cycle}/{specialite}', 'ScolariteController@select_admis_licence')->name('scolarites.select_admis_licence');
    Route::post('scolarites/diplome-licence', 'ScolariteController@diplome_licence')->name('scolarites.diplome-licence');

    // Rechercher les diplômés de master
    Route::get('scolarites/diplomes/master/{n}', 'ScolariteController@master')->name('scolarites.master');
    // Sélectionner la classe de master à imprimer
    Route::get('scolarites/diplomes/select-master/{cycle}/{specialite}', 'ScolariteController@select_admis_master')->name('scolarites.select_admis_master');
    Route::post('scolarites/diplome-master', 'ScolariteController@diplome_master')->name('scolarites.diplome-master');

    Route::get('resultatNominatifs/search/{n}', 'ResultatNominatifController@search')->name('resultatNominatifs.search');
    Route::get('resultatNominatifs/create/{specialite}/{cycle}', 'ResultatNominatifController@create')->name('resultatNominatifs.create');
    Route::post('resultatNominatifs', 'ResultatNominatifController@store')->name('resultatNominatifs.store');
    Route::get('resultatNominatifs/affiche/{specialite}/{cycle}', 'ResultatNominatifController@affiche')->name('resultatNominatifs.affiche');

    //    Route::post('notes/{enseignement}/{contrat}', 'NoteController@store')->name('notes.store');

    Route::resource('academicYears', 'AcademicYearController');

    Route::resource('contratEnseignants', 'ContratEnseignantController')->except('show');
    Route::get('contratsEnseignants/all', 'ContratEnseignantController@all')->name('contratEnseignants.all');
    Route::post('contratEnseignants/filter', 'ContratEnseignantController@filter')->name('contratEnseignants.filter');
    Route::get('contratEnseignants/versements/{id}', 'ContratEnseignantController@versements')->name('contratEnseignants.versements');
    Route::post('contratEnseignants/versements/{id}/{type?}', 'ContratEnseignantController@save')->name('contratEnseignants.save');
    Route::get('contratEnseignants/rapport/{id}', 'ContratEnseignantController@rapport')->name('contratEnseignants.rapport');
    Route::get('contratEnseignants/contrats/{id}', 'ContratEnseignantController@contrat')->name('contratEnseignants.contrat');
    Route::get('contratEnseignants/details/{id}', 'ContratEnseignantController@details')->name('contratEnseignants.details');
    Route::get('contratEnseignants/{id}/edit_payment', 'ContratEnseignantController@edit_payment')->name('contratEnseignants.edit_payment');
    Route::delete('contratEnseignants/delete/{id}', 'ContratEnseignantController@delete_payment')->name('contratEnseignants.delete_payment');
    Route::patch('contratEnseignants/update_payment/{id}', 'ContratEnseignantController@update_payment')->name('contratEnseignants.update_payment');

    Route::resource('academicCalendars', 'AcademicCalendarController');

    Route::resource('corkages', 'CorkageController')->except('create');
    Route::get('corkages/create/{id}', 'CorkageController@create')->name('corkages.create');

    // 02/08/2021
    Route::resource('pays', 'PaysController');
    Route::resource('villes', 'VilleController');

    // Gestion des logs des utilisateurs
    Route::get('users-logs', 'UserController@userLogs')->name('user-logs');
    // Afficher les logs d'un utilisateur
    Route::get('users-logs/{id}', 'UserController@showUserLogs')->name('show-logs');

    Route::get('medicals/{student_id}', 'MedicalController@index')->name('medicals.index');
    Route::get('medicals/edit/{id}', 'MedicalController@edit')->name('medicals.edit');
    Route::get('medicals/create/{student_id}', 'MedicalController@create')->name('medicals.create');
    Route::post('medicals/store', 'MedicalController@store')->name('medicals.store');
    Route::patch('medicals/{id}', 'MedicalController@update')->name('medicals.update');
    Route::delete('medicals/{id}', 'MedicalController@destroy')->name('medicals.destroy');
});

