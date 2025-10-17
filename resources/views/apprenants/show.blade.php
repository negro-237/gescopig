<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gestion Scolaire de PIGIER Cameroun</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>  
            p{
                font-size: 14px;
                color: black;
            }  

            .textStyle{
                border:1px solid black; 
                padding: 5px; 
                background-color: black; 
                color: white; 
                font-weight: bold; 
                font-size: 16px; 
                font-family: Times New Roman;
            }

            @media print {  
                .textStyle{
                    border:1px solid black; 
                    padding: 5px; 
                    background-color: red; 
                    color: white; 
                    font-weight: bold; 
                    font-size: 16px; 
                    font-family: Times New Roman;
                }
                .hide_on_print{
                    display: none;
                }
            }  
        </style>
    </head>
    <body>
        <div class="content">
            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row" style="margin:15px">
                        <div class="col-md-12">

                            <div class="row hide_on_print">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="height : 125px;">
                                    <h2>Fiche de <br>candidature</h2>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-5 text-right">
                                    <img src="{{ url('images/logo_pigier.jpg') }}" style="width:250px; height:125px" alt="">
                                </div>
                            </div>

                            <div class="row hide_on_print">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small class="textStyle">Etat civil</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                            <p>Nom(s) : {{$apprenant->nom}}</p>
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                            <p>Prénom(s) : {{$apprenant->prenom}}</p>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <p>
                                                Sexe : 
                                                @if($apprenant->sexe == 'Homme')
                                                    H
                                                @else
                                                    F
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>Adresse permanente : {{$apprenant->addresse}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Code postal  : </p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Ville  : 
                                                @if($a->contrats->first()->ville_id == 1)
                                                    Douala
                                                @else
                                                    Yaoundé
                                                @endif
                                            </p> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Tel  : {{$apprenant->tel}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Portable  :</p> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>E-mail  : {{$apprenant->email}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Nationalité  : {{ $apprenant->country ? ucfirst($apprenant->country->nom) : $apprenant->nationalite}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Date de naissance  : {{date('d-m-Y', strtotime($apprenant->dateNaissance))}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Lieu de naissance  : {{$apprenant->lieuNaissance}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Région d'origine  : {{$apprenant->region}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>Situation professionnelle  : {{$apprenant->situation_professionnelle}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>Entreprise  : {{$apprenant->entreprise}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row hide_on_print">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Situation familiale</small>
                                        </div>
                                    </div>
                                    @foreach($apprenant->tutors as $allTutors)
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                            <div class="row"> 
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <p>Nom(s) et prénom(s)  : {!! $allTutors->name !!}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <p>Profession  : {!! $allTutors->profession !!}</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <p>Tel  : {!! $allTutors->tel_mobile !!}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <p>Adresse : {!! $allTutors->addresse !!}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <p>Tel bureau  : {!! $allTutors->tel_bureau !!}</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <p>Tel fixe  : {!! $allTutors->tel_fixe !!}</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <p>Relation  : {!! $allTutors->type !!}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row hide_on_print">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Cycle demandé</small>
                                            <p style="margin-top: 25px;">
                                                @if($a->contrats->first()->cycle_id == 1 || $a->contrats->first()->cycle_id == 2 || $a->contrats->first()->cycle_id == 3 || $a->contrats->first()->cycle_id == 10 || $a->contrats->first()->cycle_id == 11 || $a->contrats->first()->cycle_id == 12)
                                                    Licence 
                                                @else
                                                    Master
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Niveau demandé</small>
                                            <p style="margin-top: 25px;">
                                                @if($a->contrats->first()->cycle_id == 1)
                                                    1
                                                @elseif($a->contrats->first()->cycle_id == 2)
                                                    2
                                                @elseif($a->contrats->first()->cycle_id == 3)
                                                    3
                                                @elseif($a->contrats->first()->cycle_id == 4)
                                                    1
                                                @else
                                                    2
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Spécialité demandée</small>
                                            <p style="margin-top: 25px;">
                                                @if($a->contrats->first()->specialite_id == 1)
                                                    Audit et Contrôle de gestion
                                                @elseif($a->contrats->first()->specialite_id == 2)
                                                    Banque et Finance d'Entreprise
                                                @elseif($a->contrats->first()->specialite_id == 3)
                                                    Communication, Marketing et Digital
                                                @elseif($a->contrats->first()->specialite_id == 4)
                                                    Transport Transit Douane Logistique
                                                @elseif($a->contrats->first()->specialite_id == 5)
                                                    Management de la Qualité et des Projets
                                                @elseif($a->contrats->first()->specialite_id == 6)
                                                    Management des Entreprises
                                                @elseif($a->contrats->first()->specialite_id == 7)    
                                                    Management des Ressources Humaines
                                                @elseif($a->contrats->first()->specialite_id == 8)
                                                    Communication, Marketing et Digital
                                                @elseif($a->contrats->first()->specialite_id == 9)
                                                    Finance
                                                @elseif($a->contrats->first()->specialite_id == 10)
                                                    Transport et Supply Chain Management
                                                @elseif($a->contrats->first()->specialite_id == 11)
                                                    Audit et Contrôle de Gestion
                                                @elseif($a->contrats->first()->specialite_id == 17)
                                                    Négociation et Communication Multimedia
                                                @elseif($a->contrats->first()->specialite_id == 18)
                                                    Management et Stratégie Digitale
                                                @elseif($a->contrats->first()->specialite_id == 19)
                                                    Intelligence Artificielle et Intelligence Economique
                                                @else
                                                    Fiscalité et Droit des Affaires
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--
                            <div class="row" style="margin-bottom: 50px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p>*FPCD : Formation Professionnelle Continue Diplômante</p>
                                </div>
                            </div>
                            -->
                            <hr class="hide_on_print">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Scolarité</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 13px;">Année (3 dernières)</th>
                                                        <th style="font-size: 13px;">Etablissement</th>
                                                        <th style="font-size: 13px;">Ville</th>
                                                        <th style="font-size: 13px;">Classe</th>
                                                        <th style="font-size: 13px;">Diplôme obtenu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$apprenant->annee1}}</td>
                                                        <td>{{$apprenant->etablissement1}}</td>
                                                        <td>{{$apprenant->ville1}}</td>
                                                        <td>{{$apprenant->classe1}}</td>
                                                        <td>{{$apprenant->diplome1}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->annee2}}</td>
                                                        <td>{{$apprenant->etablissement2}}</td>
                                                        <td>{{$apprenant->ville2}}</td>
                                                        <td>{{$apprenant->classe2}}</td>
                                                        <td>{{$apprenant->diplome2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->annee3}}</td>
                                                        <td>{{$apprenant->etablissement3}}</td>
                                                        <td>{{$apprenant->ville3}}</td>
                                                        <td>{{$apprenant->classe3}}</td>
                                                        <td>{{$apprenant->diplome3}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            Baccalauréat série : {{$apprenant->serie_baccalaureat}}
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            Mention : {{$apprenant->mention}}
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            Année : {{$apprenant->annee_baccalaureat}}
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            Autres diplômes : {{$apprenant->autre_diplome}}
                                        </div>
                                    </div>

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Langues étrangères</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 13px;">Langue</th>
                                                        <th style="font-size: 13px;">Classe</th>
                                                        <th style="font-size: 13px;">Diplôme obtenu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$apprenant->langue1}}</td>
                                                        <td>{{$apprenant->classe_langue1}}</td>
                                                        <td>{{$apprenant->diplome_langue1}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->langue2}}</td>
                                                        <td>{{$apprenant->classe_langue2}}</td>
                                                        <td>{{$apprenant->diplome_langue2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->langue3}}</td>
                                                        <td>{{$apprenant->classe_langue3}}</td>
                                                        <td>{{$apprenant->diplome_langue3}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Activités associatives ou sportives</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="col-lg-12">
                                            <p>{!! $allTutors->activites_associatives !!}</p>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Stages et expériences professionnelles</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 13px;">Année</th>
                                                        <th style="font-size: 13px;">Etablissement</th>
                                                        <th style="font-size: 13px;">Nature du stage</th>
                                                        <th style="font-size: 13px;">Nom et adresse d'entreprise</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$apprenant->annee_stage1}}</td>
                                                        <td>{{$apprenant->etablissement_stage1}}</td>
                                                        <td>{{$apprenant->nature1}}</td>
                                                        <td>{{$apprenant->nom_adresse_entreprise1}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->annee_stage2}}</td>
                                                        <td>{{$apprenant->etablissement_stage2}}</td>
                                                        <td>{{$apprenant->nature2}}</td>
                                                        <td>{{$apprenant->nom_adresse_entreprise2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$apprenant->annee_stage3}}</td>
                                                        <td>{{$apprenant->etablissement_stage3}}</td>
                                                        <td>{{$apprenant->nature3}}</td>
                                                        <td>{{$apprenant->nom_adresse_entreprise3}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Demande d'admission</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Je soussigné(e) ..........{{$apprenant->nom .' '. $apprenant->prenom}}.......... demande au jury d'admission d'examiner ma candidature à l'entrée en ..........
                                            @if($a->contrats->first()->cycle_id == 1)
                                                Licence 1
                                            @elseif($a->contrats->first()->cycle_id == 2)
                                                Licence 2
                                            @elseif($a->contrats->first()->cycle_id == 3)
                                                Licence 3
                                            @elseif($a->contrats->first()->cycle_id == 4)
                                                Master 1
                                            @else
                                                Master 2
                                            @endif
                                            ..........<br><br>
                                            Je soussigné(e) certifie exacts les renseignements fournis dans ce dossier.<br><br>
                                            Fait à ........................., le ......................... Signature .........................
                                        </div>
                                    </div>

                                    <hr class="hide_on_print">

                                    <div class="row hide_on_print" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman;">Questionnaire</small>
                                        </div>
                                    </div>

                                    <div class="row hide_on_print">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>
                                                0- Comment avez-vous connu notre établissement ? <br>{{$apprenant->q1}} 
                                            </p>
                                            <p>
                                                1- Pourquoi avez-vous décidé d'intégrer notre établissement ? <br>{{$apprenant->q2}} 
                                            </p>
                                            <p>
                                                2- Pourquoi avez-vous choisi cette formation ? <br>{{$apprenant->q3}} 
                                            </p>
                                            <p>
                                                3- Quels sont vos atouts pour réussir cette formation ? <br>{{$apprenant->q4}} 
                                            </p>
                                            <p>
                                                4- Comment envisagez vous votre avenir professionnel ? <br>{{$apprenant->q5}} 
                                            </p>
                                            <p>
                                                5- Êtes-vous intéressé(e) par une formation complémentaire, laquelle ? <br>{{$apprenant->q6}} 
                                            </p>
                                            <p>
                                                6- Quelles autres informations jugez vous utiles d'apporter pour l'appréciation de votre candidature ? (Ex: Véhicule, connaissances particulières, ...) <br>{{$apprenant->q7}} 
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="hide_on_print">

                                    <div class="row" style="margin-top: 35px; margin-bottom: 35px;">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <p style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; text-align: center; font-family: Times New Roman">Observation(s) de l'administration de l'école</p>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman">Membre de la DE</small>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 25px;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" rows="5">{{$apprenant->r1}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman">Resp. Qualité</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-bottom: 25px;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" rows="5">{{$apprenant->r2}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
                                        <div class="col-md-12">
                                            <small style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; font-family: Times New Roman">Directeur des études</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-bottom: 25px;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" rows="5">{{$apprenant->r3}}</textarea>
                                        </div>
                                    </div>

                                    @if($apprenant->file_birth)
                                        <div class="row" style="margin-top: 35px; margin-bottom: 35px;">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <p style="border:1px solid black; padding: 5px; background-color: black; color: white; font-weight: bold; font-size: 16px; text-align: center; font-family: Times New Roman">Documents</p>
                                            </div>
                                            <div class="col-md-12">
                                                <ul>
                                                    <li>
                                                        <a href="{{ asset('storage/uploads/' . $apprenant->file_birth . '') }}" target="_blanck" >Acte de Naissance</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ asset('storage/uploads/' . $apprenant->file_cni . '') }}" target="_blanck" >Recto cni</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ asset('storage/uploads/' . $apprenant->file_cni_verso . '') }}" target="_blanck" >Verso cni</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ asset('storage/uploads/' . $apprenant->file_diploma . '') }}" target="_blanck" >Dernier diplome</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ asset('storage/uploads/' . $apprenant->file_receipt . '') }}" target="_blanck" >Récu de versement</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>