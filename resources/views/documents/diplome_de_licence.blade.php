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
            .printed {
                font-size: 11px;
            }   
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid" id="rnr" style="padding: 8px; margin-top: 200px">
        <div class="row">
            <div class="col-md-12 col-sm-12">

                <div class="row">
                    <div class="col-md-8">
                        <p style="text-transform:uppercase;line-height: 12px">
                            <strong class="printed">
                                Le ministre d'etat, ministre de l'enseignement supérieur, chancelier des ordres académiques </br>
                            </strong>
                            <strong class="printed">
                                The minister of state, minister of higher education, chancellor of academic orders
                            </strong>
                        </p>
                        <p style="font-size: 11px; margin-top: -10px;line-height: 12px">
                            <i>
                                Vu le décret n°93/030 portant ordanisation de l'Université de Douala,</br>
                                Mindful of decree N° 93/030 to organize the administrative and academic structure of the University od Douala</br>
                                Vu les textes en vigueur,</br>
                                Mindful the in effect
                            </i>  
                        </p>
                        <!-- <p>
                            <strong>
                                Vu le Décret n° 93/027 du 19 janvier 1993 portant dispositions communes aux universités 
                            </strong><br>
                            <small>
                                Mindful of decree N° 93/027 of 19<sup>th</sup> january 1993 laying down general regulations governing universities
                            </small>
                        </p> -->
                    </div>
                    <div class="col-md-4">
                        <p style="text-transform:uppercase">
                            <strong class="printed">N°<span style="text-decoration: underline">
                              &ensp;&ensp;
                            </span>minesup/dcaa/ud/essec/escmp</strong>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <p style="font-size: 11px; line-height: 12px; margin-top: -7px">
                            Vu <span style="color:red">L'arrêté ministeriel N° 13/0583/MINSUP du 02 décembre 2013 ouvrant L'institut Supérieur de Commerce et de Management PIGIER Cameroun </br>
                            Mindful of the Ministerial decree N° 13/0583/MINSUP of the 2 december 2013 opening the Advanced School of Commerce and Management </span>
                        </p>
                        <p style="font-size: 10px;margin-top: -7px">
                            Vu l'accord entre l'Université de Douala et l'Ecole Superieur de Commerce et de Management Pigier-Cameroun validé par le MINESUP le 23 mai 2013</br>
                            Mindful the framework agreement between the University of Douala and 
                            <span style="color:red">the Advanced School of commerce and Management approved, by the Minister of Higher Education on May 2013</span></br>
                            Texte accordant la tutelle technique pour (le programme de formation) entre l'ESSEC et l'ESCM Pigier Cameroun
                        </p>
                    </div>
                    <div class="col-md-1">{{ $qrcode }}</div>
                </div>

               <!--  <div class="row">
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
                </div> -->

                <div class="row">
                    <div class="col-md-12">
                        <p style="line-height: 12px; font-size: 11px; margin-top: -15px">
                            <span>Vu le PV d'admission du {{$session_fr}} </span></br>
                            <span>Mindful the minutes of the admission jury seatting on </span></br>
                            <span>Vu le procès verbal des délibérations du jury, session de </span>
                            <span class="text-uppercase"> {{$session_fr}}</strong><br>
                            <span>
                                Mindful of the minutes of the admission jury, seatting on
                            </span>
                        </p>
                    </div>
                </div>

                @foreach($contrats as $contrat)
                    <div class="row" style="line-height: 12px">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <p><strong>Délivré à M./Mme/Mlle</strong><br><small><i>It is conferred to Mr/Mrs/Miss</i></small></p>
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

                    <div class="row" style="line-height: 12px; margin-top: -15px">
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

                   <!--  <div class="row">
                        <div class="col-md-2 col-sm-2"></div>
                        <div class="col-md-1 col-sm-1"><strong>Le<br>The</strong></div>
                        <div class="col-md-7 col-sm-9">
                            <p>
                                <strong>DIPLÔME DE LICENCE PROFESSIONNELLE EN SCIENCES DE GESTION</strong><br>
                                <strong>Professional Bachelor Degree in Business Administration</strong>
                            </p>
                        </div>
                        <div class="col-md-2 col-sm-2">{{ $qrcode }}</div>
                    </div> -->

                    <div class="row" style="line-height: 12px;">
                        <div class="col-md-2 col-sm-2">
                            <p><strong>Le Diplôme de </strong><br><small><i>The degree of</i></small></p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>
                                <strong>
                                    LICENCE PROFESSIONELLE 
                                </strong>
                            </p>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-md-2 col-sm-2">
                                    <p>
                                        <strong>Option.</strong><br>
                                        <small><i>Option.</i></small>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <p>
                                        <strong class="text-uppercase">{{ $contrat->specialite->title }}</strong><br>
                                        <small>{{ $speciality[$contrat->specialite->slug] }}</small>
                                    </p>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <p style="line-height: 12px"><strong class="text-uppercase">MENTION</strong><br><small><i>Mention:</i></small><br><strong>Fait à Douala, le</strong><br><small><i>Issued at Douala, on:</i></p>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <p class="text-uppercase"><b id="{{ 'mention-'. $contrat->id }}"></b></p>
                                        </div>
                                    </div>
                                </div>
                        <!-- <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-5 col-sm-5">
                            <p>
                                <strong>Fait à Douala, le ........................................................................</strong><br>
                                <small><i>Issued at</i></small> 
                                <small style="margin-left: 150px"><i>on</i></small>
                            </p>
                        </div> -->
                    </div>

                    <div class="row" style="line-height: 12px; margin-top: -15px">
                        <div class="col-md-3 col-sm-3">
                            <p>
                                <small><b>L'impétrant</b></small><br>
                                <small>The Holder</small>
                            </p>
                        </div>  
                        <!-- <div class="col-md-3 col-sm-3">
                            <p>
                                <small><b>Le Responsable Académique de Pigier</b></small><br>
                                <small>The Head Teacher</small>
                            </p>
                        </div> -->
                        <div class="col-md-4 col-sm-4">
                            <p>
                                <small><b>Le Recteur</small><br>
                                <small>The Rector</small>
                            </p>
                        </div>
                        <div class="col-md-5 col-sm-5">
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

                    <div class="row" style="margin-top: 33px;">
                        <div class="col-md-12">
                            <!-- <p><i>{{$contrat->apprenant->nom}}</i></p> -->
                            <p style="text-align:center; font-size: 9px">
                                <i>
                                    En foi de quoi le diplôme lui est delivré pour servir et valoir ce que de droit/In witness whereof, this diploma is issued to serve as and where necessary
                                </i>
                            </p>
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
            console.log('moyenne', {{$contrat->semestre_infos->sum('moyenne')}})
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