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
        </style>
    </head>
    <body>
        <div class="content">
            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">

                    <div class="row" style="margin:15px">
                        <div class="col-md-12">

                        	<div class="row">
                                <div class="col-md-12">
                                    <img src="{{ url('images/logo_pigier.jpg') }}" style="width:250px; height:125px" alt="">
                                </div>
                            </div>

                            <div class="row" style="border:1px solid black; margin-bottom: 25px;">
                            	<div class="col-md-12">
                            		<h1 style="text-align: center;">FICHE MEDICALE INDIVIDUELLE</h1>
                            	</div>
                            </div>

                            <div class="row" style="border:1px solid purple">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                	<div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Nom(s) : {{$apprenant->nom}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Prénom(s) : {{$apprenant->prenom}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Date de naissance  : {{date('d-m-Y', strtotime($apprenant->dateNaissance))}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Lieu de naissance : {{$apprenant->lieuNaissance}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                    	<div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Nationalité  : {{$apprenant->nationalite}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
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
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p>Adresse : {{$apprenant->addresse}}</p>
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
	                                        <p>E-mail  : {{$apprenant->email}}</p> 
	                                    </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin-top: 25px; margin-bottom: 5px;">
                                <div class="col-md-12">
                                    <p style="font-weight: bold;">PERSONNE A CONTACTER EN CAS D'URGENCE</p>
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
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>Adresse : {!! $allTutors->addresse !!}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p>Téléphone : {!! $allTutors->tel_mobile !!}</p>
                                        </div>
                                    </div>

                            	</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>