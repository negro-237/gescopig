<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Scolaire de PIGIER Cameroun</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>            
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
                        <div class="col-lg-12">
                            <img src="{{ url('images/logo_pigier.jpg') }}" style="width:250px; height:125px" alt="">
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <div class="row"  style="margin:2px">
                                <div class="col-lg-12" style="border: 1px solid black;">
                                    <h3 style="text-align: center;">FICHE D'EMARGEMENT DES ENSEIGNANTS</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p style="text-decoration: underline; text-align: center; margin-top: 20px">Année {{ $enseignement->academic_year->debut }} - {{ $enseignement->academic_year->fin }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Grade:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{ $enseignement->ecue->semestre->cycle->label }}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Niveau:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{ $enseignement->ecue->semestre->cycle->niveau }}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Spécialité:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{$enseignement->specialite->slug}}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Semestre:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{$enseignement->ecue->semestre->title}}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        ECUE:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{$enseignement->ecue->title}} ({{$enseignement->enseignement_type}})
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        MH:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{$enseignement->mhTotal}}
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Enseignant:
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        {{$enseignement->contratEnseignant->enseignant->name}}
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        Ville:
                                    </small>
                                    @if($enseignement->ville_id === 1)
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">Douala</small>
                                    @else
                                        <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">Yaoundé</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12" style="margin-top:30px">
                            @include('enseignements.show_fields')
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <p>NB: La fiche est renseignée et visée par le Surveillant Général, signée par l'enseignant.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- jQuery 3.1.1 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>