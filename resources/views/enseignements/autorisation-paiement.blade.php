<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Scolaire de PIGIER Cameroun</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            th, td{
                font-size: 16px;
            }            
            @media print { 
                .table td, .table th { 
                    border: 1px solid #000000 !important;
                } 
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row" style="margin:10px">
                        <div class="col-xs-3 logo">
                            <div><img src="{{ url('images/logo_pigier.jpg') }}" style="width:250px; height:125px" alt=""></div>
                        </div>
                        <div class="col-xs-6"></div>
                        <div class="col-xs-3 pull-right pt-5">
                            <div>
                                <h4>Réf: PIG/RFO/F/029</h4>
                                <h4>Version: 1.0 </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h3 style="text-decoration: underline;">FICHE D'AUTORISATION DE PAIEMENT</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p style="text-decoration: underline; text-align: center">Année {{ $enseignement->academic_year->debut }} - {{ $enseignement->academic_year->fin }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p>(A remplir par le responsable des études ou son représentant)</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Nom et prénom(s) de l'enseignant :
                                    </small>
                                    <small style="font-size:16px; color: #000000">
                                        {{$enseignement->contratEnseignant->enseignant->name}}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Grade:
                                    </small> 
                                    <small style="font-size:16px; color: #000000">
                                        {{ $enseignement->ecue->semestre->cycle->label }}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Spécialité :
                                    </small> 
                                    <small style="font-size:16px; color: #000000">
                                        {{$enseignement->specialite->slug}} {{ $enseignement->ecue->semestre->cycle->niveau }}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <small style="font-size : 16px; font-weight: bold;">
                                        Libellé du cours :
                                    </small> 
                                    <small style="font-size:16px; color: #000000">
                                        {{$enseignement->ecue->title}} ({{$enseignement->enseignement_type}})
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Date de début du cours :
                                    </small> 
                                    <small style="font-size:16px;color: #000000">
                                        {{date('d-m-Y', strtotime($enseignement->dateDebut))}}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Date de fin du cours :
                                    </small> 
                                    <small style="font-size:16px;color: #000000">
                                        {{date('d-m-Y', strtotime($enseignement->dateFin))}}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 16px; font-weight: bold;">
                                        Nombre d'heures réalisées :
                                    </small> 
                                    <small style="font-size:16px;color: #000000">
                                        {{$enseignement->mhEff}}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Rémunération brute horaire :
                                    </small>
                                    @if( $enseignement->ecue->semestre->cycle->label == "Licence" ) 
                                        <small style="font-size:18px;color: #000000">
                                            {{$enseignement->contratEnseignant->mh_licence}}
                                        </small>
                                    @elseif( $enseignement->ecue->semestre->cycle->label == "Master" )
                                        <small style="font-size:18px;color: #000000">
                                            {{$enseignement->contratEnseignant->mh_master}}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Téléphone :
                                    </small> 
                                    <small style="font-size:18px;color: #000000">
                                        {{$enseignement->contratEnseignant->enseignant->tel}}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Ville :
                                    </small> 
                                    <small style="font-size:18px;color: #000000">
                                        {{$enseignement->ville->nom}}
                                    </small>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;margin-bottom: 10px;">
                                <div class="col-lg-12">
                                    <small style="font-weight: bold;font-size:18px;color: #000000">
                                        Restitution des documents de la direction des études (cf. contrat)
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>N°</th>
                                                <th>Documents</th>
                                                <th>Observation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01</td>
                                                <td>Note de cours</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>02</td>
                                                <td>Les notes du contrôle continu</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>03</td>
                                                <td>Deux sujets de l'examen de fin de semestre + corrigés types</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>04</td>
                                                <td>Fiche de progression</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>05</td>
                                                <td>Contrat</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>06</td>
                                                <td>Les fiches de communication</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>07</td>
                                                <td>Liste de trois ouvrages pour la bibliothèque</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 60px;">
                                <div class="col-lg-12">
                                    <small style="font-weight: bold;font-size:18px;color: #000000">
                                        Le directeur des études
                                    </small>
                                </div>
                            </div>
                            <hr style="border:1px solid #000">
                            <h4 class="text-center" style="color:#000000">PARTIE RESERVEE A LA DIRECTION ADMINISTRATIVE ET FINANCIERE</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center">Désignation</th>
                                                <th class="text-center">Montant</th>
                                                <th class="text-center">Signature CI</th>
                                                <th class="text-center">Signature DAF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>Brut</td>
                                                <td>
                                                    @if( $enseignement->ecue->semestre->cycle->label == "Licence" ) 
                                                        <small style="font-size:18px;color: #000000">
                                                            {{$enseignement->contratEnseignant->mh_licence * $enseignement->mhEff}}
                                                        </small>
                                                    @elseif( $enseignement->ecue->semestre->cycle->label == "Master" )
                                                        <small style="font-size:18px;color: #000000">
                                                            {{$enseignement->contratEnseignant->mh_master * $enseignement->mhEff}}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td rowspan="3"></td>
                                                <td rowspan="3"></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>RAT (5.5%)</td>
                                                <td>
                                                    @if( $enseignement->ecue->semestre->cycle->label == "Licence" ) 
                                                        <small style="font-size:18px;color: #000000">
                                                            {{($enseignement->contratEnseignant->mh_licence * $enseignement->mhEff)*0.055}}
                                                        </small>
                                                    @elseif( $enseignement->ecue->semestre->cycle->label == "Master" )
                                                        <small style="font-size:18px;color: #000000">
                                                            {{($enseignement->contratEnseignant->mh_master * $enseignement->mhEff) * 0.055}}
                                                        </small>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>NAP</td>
                                                <td>
                                                    @if( $enseignement->ecue->semestre->cycle->label == "Licence" ) 
                                                        <small style="font-size:18px;color: #000000">
                                                            {{
                                                                ($enseignement->contratEnseignant->mh_licence * $enseignement->mhEff)-(($enseignement->contratEnseignant->mh_licence * $enseignement->mhEff)*0.055)
                                                            }}
                                                        </small>
                                                    @elseif( $enseignement->ecue->semestre->cycle->label == "Master" )
                                                        <small style="font-size:18px;color: #000000">
                                                            {{
                                                                ($enseignement->contratEnseignant->mh_master * $enseignement->mhEff)-(($enseignement->contratEnseignant->mh_master * $enseignement->mhEff) * 0.055)
                                                            }}
                                                        </small>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>