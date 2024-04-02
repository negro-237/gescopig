<div class="box box-primary">
    <div class="box-body">

        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('nom', 'Nom ') !!}<span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('nom', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('prenom', 'Prenom') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('prenom', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('sexe', 'Sexe') !!}<span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::select('sexe',['Homme'=>'Homme', 'Femme'=>'Femme'],isset($apprenant)? $apprenant->sexe : null,['class' => 'form-control', 'placeholder' => 'choisissez le sexe de l\'apprenant']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('dateNaissance', 'Date de naissance') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::date('dateNaissance', isset($apprenant) ? Carbon\Carbon::parse($apprenant->dateNaissance) : null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('lieuNaissance', 'Lieu de Naissance') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('lieuNaissance', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('nationalite', 'Nationalite') !!}<span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::select('nationalite',isset($countries) ? $countries : [], isset($countries) && isset($apprenant->country) ? $apprenant->country->id : null, ['class' => 'form-control', 'placeholder' => 'Sélectionnez la nationalité']) !!}
                        <!-- {!! Form::text('nationalite', null, ['class' => 'form-control']) !!} -->
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('addresse', 'Adresse') !!}<span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('addresse', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('tel', 'Tel') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('tel', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('phone', 'Tel 2 :') !!}
                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('email', 'Email') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('region', 'Region d\'origine') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('region', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('civilite', 'Civilite') !!}<span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::select('civilite',
                         ['marié(e)' => 'Marié(e)', 'célibataire' => 'Celibataire', 'divorcé(e)' => 'Divorcé(e)',
                          'veuf(ve)' => 'Veuf(ve)'], isset($apprenant)? $apprenant->civilite : null, ['class' => 'form-control', 'placeholder' => 'sélectionnez le statut']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('quartier', 'Quartier') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('quartier', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('diplome', 'Niveau / Dernier diplôme') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('diplome', null, ['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group col-xs-4">
                        {!! Form::label('etablissement_provenance', 'Etablissement de Provenance') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('etablissement_provenance', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('situation_professionnelle', 'Situation Professionnelle') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('situation_professionnelle', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('entreprise', 'Entreprise') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('entreprise', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('academic_year_id', 'Année Académique') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::select('academic_year_id',$academicYears, isset($apprenant)? $apprenant->academic_year_id : null, ['class' => 'form-control', 'placeholder' => 'sélectionnez l\'année']) !!}
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('academic_year_id', 'Année Académique') !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::select('academic_year_id',$academicYears, isset($apprenant)? $apprenant->academic_year_id : null, ['class' => 'form-control', 'placeholder' => 'sélectionnez l\'année']) !!}
                    </div>
                </div> -->

            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                @if(!isset($apprenant))
                    <div class="row">
                        <!--<h4 class="col-sm-3"><strong>Filiere, niveau et ville</strong></h4><hr>-->
                        <div class="col-md-12">
                            <h4><strong>FILIERE, NIVEAU & VILLE</strong></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-4">
                            {!! Form::label('specialite_id', 'Specialite') !!} <span class="bold"><b class="notif"> * </b>:</span>
                            {!! Form::select('specialite_id',isset($specialites) ? $specialites : [], null, ['class' => 'form-control', 'placeholder' => 'sélectionnez la specialite']) !!}
                        </div>
                        <div class="form-group col-xs-4">
                            {!! Form::label('cycle_id', 'Niveau') !!} <span class="bold"><b class="notif"> * </b>:</span>
                            {!! Form::select('cycle_id',isset($cycles) ? $cycles : [], null, ['class' => 'form-control', 'placeholder' => 'sélectionnez le niveau']) !!}
                        </div>
                        <div class="form-group col-xs-4">
                            {!! Form::label('ville_id', 'Ville') !!} <span class="bold"><b class="notif"> * </b>:</span>
                            {!! Form::select('ville_id',isset($villes) ? $villes : [], null, ['class' => 'form-control', 'placeholder' => 'sélectionnez la ville']) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>

@can('more details')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <button type="button" class="Show btn btn-default">Afficher</button>
        <button type="button" class="Hide btn btn-default" style="display:none;">Masquer</button>
    </div>
</div>
@endcan

<div class="box box-primary" id="target" style="display:none;">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>SCOLARITE</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-2">
                        {!! Form::label('annee1', 'Année :') !!}
                        {!! Form::text('annee1', null, ['class' => 'form-control','name' => 'annee1']) !!}
                    </div>

                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement1', 'Etablissement :') !!}
                        {!! Form::text('etablissement1', null, ['class' => 'form-control', 'name' => 'etablissement1']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('ville1', 'Ville :') !!}
                        {!! Form::text('ville1', null, ['class' => 'form-control', 'name' => 'ville1']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('classe1', 'Classe :') !!}
                        {!! Form::text('classe1', null, ['class' => 'form-control', 'name' => 'classe1']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('diplome1', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome1', null, ['class' => 'form-control', 'name' => 'diplome1']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-2">
                        {!! Form::label('annee2', 'Année :') !!}
                        {!! Form::text('annee2', null, ['class' => 'form-control','name' => 'annee2']) !!}
                    </div>

                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement2', 'Etablissement :') !!}
                        {!! Form::text('etablissement2', null, ['class' => 'form-control', 'name' => 'etablissement2']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('ville2', 'Ville :') !!}
                        {!! Form::text('ville2', null, ['class' => 'form-control', 'name' => 'ville2']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('classe2', 'Classe :') !!}
                        {!! Form::text('classe2', null, ['class' => 'form-control', 'name' => 'classe2']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('diplome2', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome2', null, ['class' => 'form-control', 'name' => 'diplome2']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-2">
                        {!! Form::label('annee3', 'Année :') !!}
                        {!! Form::text('annee3', null, ['class' => 'form-control','name' => 'annee3']) !!}
                    </div>

                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement3', 'Etablissement :') !!}
                        {!! Form::text('etablissement3', null, ['class' => 'form-control','name' => 'etablissement3']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('ville3', 'Ville :') !!}
                        {!! Form::text('ville3', null, ['class' => 'form-control','name' => 'ville3']) !!}
                    </div>
                    <div class="form-group col-xs-2">
                        {!! Form::label('classe3', 'Classe :') !!}
                        {!! Form::text('classe3', null, ['class' => 'form-control','name' => 'classe3']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('diplome3', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome3', null, ['class' => 'form-control','name' => 'diplome3']) !!}
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-xs-3">
                        {!! Form::label('serie_baccalaureat', 'Baccalauréat série :') !!}
                        {!! Form::text('serie_baccalaureat', null, ['class' => 'form-control','name' => 'serie_baccalaureat']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('mention', 'Mention :') !!}
                        {!! Form::text('mention', null, ['class' => 'form-control','name' => 'mention']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('annee_baccalaureat', 'Année :') !!}
                        {!! Form::text('annee_baccalaureat', null, ['class' => 'form-control','name' => 'annee_baccalaureat']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('autre_diplome', 'Autres diplômes :') !!}
                        {!! Form::text('autre_diplome', null, ['class' => 'form-control','name' => 'autre_diplome']) !!}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>LANGUES ETRANGERES</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('langue1', 'Langue :') !!}
                        {!! Form::text('langue1', null, ['class' => 'form-control','name' => 'langue1']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('classe_langue1', 'Classe :') !!}
                        {!! Form::text('classe_langue1', null, ['class' => 'form-control','name' => 'classe_langue1']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('diplome_langue1', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome_langue1', null, ['class' => 'form-control','name' => 'diplome_langue1']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('langue2', 'Langue :') !!}
                        {!! Form::text('langue2', null, ['class' => 'form-control','name' => 'langue2']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('classe_langue2', 'Classe :') !!}
                        {!! Form::text('classe_langue2', null, ['class' => 'form-control','name' => 'classe_langue2']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('diplome_langue2', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome_langue2', null, ['class' => 'form-control','name' => 'diplome_langue2']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('langue3', 'Langue :') !!}
                        {!! Form::text('langue3', null, ['class' => 'form-control','name' => 'langue3']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('classe_langue3', 'Classe :') !!}
                        {!! Form::text('classe_langue3', null, ['class' => 'form-control','name' => 'classe_langue3']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('diplome_langue3', 'Diplôme obtenu :') !!}
                        {!! Form::text('diplome_langue3', null, ['class' => 'form-control','name' => 'diplome_langue3']) !!}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>ACTIVITES ASSOCIATIVES OU SPORTIVES</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::textarea('activites_associatives', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>STAGES & EXPERIENCES PROFESSIONNELLES</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-3">
                        {!! Form::label('annee_stage1', 'Année :') !!}
                        {!! Form::text('annee_stage1', null, ['class' => 'form-control','name' => 'annee_stage1']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement_stage1', 'Etablissement :') !!}
                        {!! Form::text('etablissement_stage1', null, ['class' => 'form-control','name' => 'etablissement_stage1']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nature1', 'Nature du stage :') !!}
                        {!! Form::text('nature1', null, ['class' => 'form-control','name' => 'nature1']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nom_adresse_entreprise1', 'Nom et adresse d\'entreprise :') !!}
                        {!! Form::text('nom_adresse_entreprise1', null, ['class' => 'form-control','name' => 'nom_adresse_entreprise1']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-3">
                        {!! Form::label('annee_stage2', 'Année :') !!}
                        {!! Form::text('annee_stage2', null, ['class' => 'form-control','name' => 'annee_stage2']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement_stage2', 'Etablissement :') !!}
                        {!! Form::text('etablissement_stage2', null, ['class' => 'form-control','name' => 'etablissement_stage2']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nature2', 'Nature du stage :') !!}
                        {!! Form::text('nature2', null, ['class' => 'form-control','name' => 'nature2']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nom_adresse_entreprise2', 'Nom et adresse d\'entreprise :') !!}
                        {!! Form::text('nom_adresse_entreprise2', null, ['class' => 'form-control','name' => 'nom_adresse_entreprise2']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-3">
                        {!! Form::label('annee_stage3', 'Année :') !!}
                        {!! Form::text('annee_stage3', null, ['class' => 'form-control','name' => 'annee_stage3']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('etablissement_stage3', 'Etablissement :') !!}
                        {!! Form::text('etablissement_stage3', null, ['class' => 'form-control','name' => 'etablissement_stage3']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nature3', 'Nature du stage :') !!}
                        {!! Form::text('nature3', null, ['class' => 'form-control','name' => 'nature3']) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('nom_adresse_entreprise3', 'Nom et adresse d\'entreprise :') !!}
                        {!! Form::text('nom_adresse_entreprise3', null, ['class' => 'form-control','name' => 'nom_adresse_entreprise3']) !!}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>QUESTIONNAIRE</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q1', 'Comment avez-vous connu notre établissement ?') !!}
                        {!! Form::textarea('q1', null, ['class' => 'form-control', 'name' => 'q1']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q2', 'Pourquoi avez-vous décidé d\'intégrer notre établissement ?') !!}
                        {!! Form::textarea('q2', null, ['class' => 'form-control', 'name' => 'q2']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q3', 'Pourquoi avez-vous choisi cette formation ?') !!}
                        {!! Form::textarea('q3', null, ['class' => 'form-control', 'name' => 'q3']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q4', 'Quels sont vos atouts pour réussir cette formation ?') !!}
                        {!! Form::textarea('q4', null, ['class' => 'form-control', 'name' => 'q4']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q5', 'Comment envisagez vous votre avenir professionnel ?') !!}
                        {!! Form::textarea('q5', null, ['class' => 'form-control', 'name' => 'q5']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q6', 'Etes-vous intéressé(e) par une formation complémentaire, laquelle ?') !!}
                        {!! Form::textarea('q6', null, ['class' => 'form-control', 'name' => 'q6']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::label('q7', 'Quelles autres informations jugez vous utiles d\'apporter pour l\'appréciation de votre candidature ? (Ex: Véhicule, connaissances particulières,...)') !!}
                        {!! Form::textarea('q7', null, ['class' => 'form-control', 'name' => 'q7']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@can('observation un')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <button type="button" class="Show1 btn btn-default">Membre de la DE</button>
        <button type="button" class="Hide1 btn btn-default" style="display:none;">Masquer </button>
    </div>
</div>
@endcan

@can('observation deux')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <button type="button" class="Show2 btn btn-default">Resp. Qualité</button>
        <button type="button" class="Hide2 btn btn-default" style="display:none;">Masquer </button>
    </div>
</div>
@endcan

@can('observation trois')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <button type="button" class="Show3 btn btn-default">Directeur des études</button>
        <button type="button" class="Hide3 btn btn-default" style="display:none;">Masquer </button>
    </div>
</div>
@endcan

<div class="box box-primary" id="target1" style="display:none;">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>MEMBRE DE LA DE</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::textarea('r1', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="box box-primary" id="target2" style="display:none;">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>Resp. Qualité</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::textarea('r2', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="box box-primary" id="target3" style="display:none;">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>Directeur des études</strong></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        {!! Form::textarea('r3', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@if(!isset($apprenant))
    <div id="parent1">
        <h3>Informations du parent 1</h3>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-xs-4">
                        {!! Form::label('name1', 'Nom du Parent', ['class' => 'nameLabel']) !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('name1', isset($apprenant)? $apprenant->tutor->name : null, ['class' => 'form-control nameInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('profession1', 'Profession', ['class' => 'professionLabel']) !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('profession1', isset($apprenant)? $apprenant->tutor->profession : null, ['class' => 'form-control professionInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('addresse1', 'Adresse', ['class' => 'addresseLabel']) !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('addresse1', isset($apprenant)? $apprenant->tutor->addresse : null, ['class' => 'form-control addresseInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('tel_mobile1', 'Portable', ['class' => 'tel_mobileLabel']) !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('tel_mobile1', isset($apprenant)? $apprenant->tutor->tel_mobile : null, ['class' => 'form-control tel_mobileInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('tel_fixe1', 'Fixe :', ['class' => 'tel_fixeLabel']) !!}
                        {!! Form::text('tel_fixe1', isset($apprenant)? $apprenant->tutor->tel_fixe : null, ['class' => 'form-control tel_fixeInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('tel_bureau1', 'Bureau :', ['class' => 'tel_bureauLabel']) !!}
                        {!! Form::text('tel_bureau1', isset($apprenant)? $apprenant->tutor->tel_bureau : null, ['class' => 'form-control tel_bureauInput']) !!}
                    </div>

                    <div class="form-group col-xs-4">
                        {!! Form::label('type1', 'relation avec l\'apprenant', ['class' => 'typeLabel']) !!} <span class="bold"><b class="notif"> * </b>:</span>
                        {!! Form::text('type1', isset($apprenant)? $apprenant->tutor->type : null, ['class' => 'form-control typeInput']) !!}
                    </div>
                    <!--
                    <div class="form-group col-xs-4">
                        {!! Form::label('email1', 'Email parent :', ['class' => 'typeLabel']) !!}
                        {!! Form::text('email', isset($apprenant)? $apprenant->tutor->emailParent : null, ['class' => 'form-control typeInput']) !!}
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-xs-12 button-container">
    @if(!isset($apprenant))
    <a href="#" class="btn btn-primary" id="ajouter">ajouter parent</a>
    @endif
    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'save']) !!}
    <a href="{!! route('apprenants.index') !!}" class="btn btn-default">Cancel</a>
</div>
