@extends('layouts.app')

@section("css")
    <style>
        @media print{
            .main-footer{
                display: none;
            }    
            p{
                font-size: 12.5px;
                font-family: "Times New Roman";
                color: black;
            }   
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid" id="rnr" style="padding: 15px; margin-top: 160px">
        <div class="row">
            <div class="col-md-12 col-sm-12">

                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <strong>
                                Vu le Décret n° 93/027 du 19 janvier 1993 portant dispositions communes aux universités 
                            </strong><br>
                            <small>
                                Mindful of decree N° 93/027 of 19<sup>th</sup> january 1993 laying down general regulations governing universities
                            </small>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <strong>
                                Vu l'accord cadre de Tutelle Académique de l'université de Douala sur l'Ecole Supérieure de Commerce et de Management Pigier - Cameroun validé par le MINESUP le 23 mai 2013, 
                            </strong><br>
                            <small>
                                Mindful of the framework agreement of the Advanced School of Management and Commerce Pigier-Cameroon attached to Douala University approved, by the Ministry of Higher Education on May, 23<sup>rd</sup> 2013
                            </small>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <strong>Vu le procès verbal des délibérations du jury, session de </strong>
                            <strong class="text-uppercase"> {{$session_fr}}</strong><br>
                            <small>
                                Mindful of the minutes of the deliberations of the promotion jury sitting on
                            </small>
                            <small class="text-uppercase"> {{$session_en}}</small>
                        </p>
                    </div>
                </div>

                @foreach($contrats as $contrat)
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <p><strong>Il est délivré à </strong><br><small><i>It is conferred on</i></small></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <p>
                                <strong class="text-uppercase">{{$contrat->apprenant->nom}}</strong>
                                <strong>{{$contrat->apprenant->prenom }}</strong>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <p>
                                <strong><i>N° Matricule  {{ $contrat->apprenant->matricule }}</i></strong><br>
                                <small><i>Registration N°</i></small>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <p>
                                <strong>Né(e) le </strong><br>
                                <small>Born on</small>
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <p>
                                @if($contrat->apprenant->dateNaissance->formatLocalized('%B') == "January")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d JANVIER %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "February")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d FEVRIER %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "March")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d MARS %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "April")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d AVRIL %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "May")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d MAI %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "June")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d JUIN %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "July")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d JUILLET %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "August")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d AOÛT %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "September")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d SEPTEMBRE %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "October")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d OCTOBRE %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "November")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d NOVEMBRE %Y') }}
                                    </strong>
                                @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "December")
                                    <strong class="text-uppercase">
                                        {{ $contrat->apprenant->dateNaissance->formatLocalized('%d DECEMBRE %Y') }}
                                    </strong>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-1 col-sm-1">
                            <p>
                                <strong class="paragraphe2">à </strong><br>
                                <small>at</small>
                            </p>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <p>
                                <strong class="paragraphe2">{{ $contrat->apprenant->lieuNaissance }} </strong>
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-3"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-2"></div>
                        <div class="col-md-1 col-sm-1"><strong>Le<br>The</strong></div>
                        <div class="col-md-9 col-sm-9">
                            <p>
                                <strong>DIPLÔME DE MASTER PROFESSIONNEL EN SCIENCES DE GESTION</strong><br>
                                <strong>Professional Master Degree in Business Administration</strong>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            <p><strong>SPECIALITE </strong><br><small><i>Speciality</i></small></p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>
                                <strong class="text-uppercase">{{ $contrat->specialite->title }}</strong><br>
                                <small>{{ $speciality[$contrat->specialite->slug] }}</small>
                            </p>
                        </div>
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-1 col-sm-1">
                            <p><strong class="text-uppercase">MENTION</strong> <br><small><i>Distinction:</i></small></p>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <p class="text-uppercase"><b id="{{ 'mention-'. $contrat->id }}"></b></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <p>
                                <strong>Pour en jouir les droits et prérogatives qui y sont attachés.</strong><br>
                                <small><i>With all the rights and privileges appertaining thereto.</i></small>
                            </p>
                        </div>
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-5 col-sm-5">
                            <p>
                                <strong>Fait à Douala, le ........................................................................</strong><br>
                                <small><i>Issued at</i></small> 
                                <small style="margin-left: 150px"><i>on</i></small>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                            <p>
                                <small><b>L'impétrant</b></small><br>
                                <small>The Holder</small>
                            </p>
                        </div>  
                        <div class="col-md-3 col-sm-3">
                            <p>
                                <small><b>Le Responsable Académique de Pigier</b></small><br>
                                <small>The Head Teacher</small>
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <p>
                                <small><b>Le Recteur de l'Université de Douala</b></small><br>
                                <small>The Rector of Douala University</small>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <p>
                                <small><b>
                                    Le Ministre d'Etat Ministre de l'Enseignement Supérieur, <br>
                                    Chancelier des Ordres Académiques
                                </b></small><br>
                                <small>
                                    The Minister of State Minister of Higher Education, <br>
                                    Chancellor of Academics Orders
                                </small>
                            </p>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <p><i>{{$contrat->apprenant->nom}}</i></p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

@section("scripts")
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script>
    function imprimer(rnr){
        var printContents = document.getElementById(rnr).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    $(function () {
        @foreach($contrats as $contrat)
            var moy = parseInt({{ $contrat->semestre_infos->sum('moyenne')/2 }})
            if (moy < 12) {
                $("{{ "#mention-".$contrat->id }}").html("Passable")
            }
            else if (moy < 14) {
                $("{{ "#mention-".$contrat->id }}").html("Assez bien")
            }
            else if (moy < 16) {
                $("{{ "#mention-".$contrat->id }}").html("Bien")
            }
            else if (moy < 18) {
                $("{{ "#mention-".$contrat->id }}").html("Très Bien")
            }
            else if (moy <= 20) {
                $("{{ "#mention-".$contrat->id }}").html("Excellent")
            }
        @endforeach
        var printContents = document.getElementById('rnr').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        window.onload = window.print(printContents);
        document.body.innerHTML = originalContents;
    })
</script>
@endsection