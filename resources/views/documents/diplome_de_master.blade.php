@extends('layouts.app')

@section("css")
    <style>
        @media print{
            .main-footer {
                display: none;
            }    
            p {
                font-size: 12.5px;
                font-weight: normal
            }
            .printed {
                font-size: 11px;
            }
            i {
                font-weight: normal
            }   
            @page {
                size: A4 paysage;
                margin:1cm;
            }
            ::-webkit-scrollbar {
                display: none;
            }
            body {
                font-family: "Times New Roman";
            }
            .born {
                overflow-wrap: break-word;
                max-width: 200px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid" id="rnr" style="padding: 8px; margin-top: 210px">
        <div class="row">
            <div class="col-md-12 col-sm-12">

                <div class="row">
                    <div class="col-md-8">
                        <p style="text-transform:uppercase;line-height: 12px">
                            <strong class="printed">
                                Le ministre d'etat, ministre de l'enseignement superieur, chancelier des ordres academiques </br>
                            </strong>
                            <strong class="printed">


                                The minister of state, minister of higher education, chancellor of academic orders
                            </strong>
                        </p>
                        <p style="font-size: 11px; margin-top: -10px;line-height: 12px">
                                Vu le décret n°93/030 portant organisation de l'Université de Douala,</br>
                                Mindful of decree N° 93/030 to organize the administrative and academic structure of the University of Douala</br>
                                Vu les textes en vigueur,</br>
                                Mindful of the text in force
                        </p>
                    </div>
                    <div class="col-md-4" style="display: flex; align-items: end">
                        <p style="text-transform:uppercase"></br>
                            <strong class="printed">N°<span style="text-decoration: underline">
                              &ensp;&ensp;&ensp;&ensp;&ensp;
                            </span>minesup/sg/dcaa/ud/essec/escmpc</strong>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <p style="font-size: 11px; line-height: 12px; margin-top: -10px">
                            Vu <span>l'arrêté ministériel N° 13/0583/MINESUP du 02 décembre 2013 ouvrant l'Ecole Supérieure de Commerce et de Management Pigier Cameroun </br>
                            Mindful of the Ministerial decree N° 13/0583/MINESUP on the 2<sup>nd</sup> of december 2013 opening the Advanced School of Commerce and Management </span>
                        </p>
                        <p style="font-size: 9.5px;margin-top: -10px; line-height: 12px;">
                            Vu l'accord entre l'Université de Douala et l'Ecole Supérieure de Commerce et de Management Pigier Cameroun validé par le MINESUP le 23 mai 2013</br>
                            Mindful of the framework agreement between the University of Douala and 
                            <span>the Advanced School of Commerce and Management approved, by the Minister of Higher Education on the 23<sup>rd</sup> of may 2013</span></br>
                            Vu le texte accordant la tutelle technique pour le programme de formation entre l'ESSEC et l'ESCM Pigier Cameroun</br>
                            Mindful of the text approving the technical mentorship for the training program between ESSEC and ESCM Pigier Cameroon 
                        </p>
                    </div>
                    <div class="col-md-2">{{ $qrcode }}</div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <p style="line-height: 12px; font-size: 11px; margin-top: -10px">
                            <span>Vu le procès-verbal d'admission du {{$session_fr}} </span></br>
                            <span>Mindful of the minutes of the admission jury sitting on </span></br>
                            <span>Vu le procès-verbal des délibérations du jury, session de </span>
                            <span> {{ucwords($session_en)}}.</strong><br></span>
                            <span>
                                Mindful of the minutes of the jury's deliberations on
                            </span>
                        </p>
                    </div>
                    <div class="col-sm-3">
                            <p style="line-height: 12px">
                                <strong>N° Matricule  {{ $contrats[0]->apprenant->matricule }}</strong><br>
                                <small>Registration N°</small>
                            </p>
                    </div>
                </div>

                @foreach($contrats as $contrat)
                    <div class="row" style="line-height: 12px">
                        <div class="col-sm-2">
                            <p><strong>Délivre à M./Mme/Mlle</strong><br><small>Is conferred to Mr/Mrs/Miss</small></p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                <strong class="text-uppercase">{{$contrat->apprenant->nom}}</strong>
                                <strong>{{$contrat->apprenant->prenom }}</strong>
                            </p>
                        </div>

                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>Né(e) le </strong><br>
                                    <small>Born on the</small>
                                </div>
                                <div class="col-sm-4" style="font-size: 12px">
                                    @if($contrat->apprenant->dateNaissance->formatLocalized('%B') == "January")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Janvier %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "February")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Février %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "March")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Mars %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "April")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Avril %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "May")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Mai %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "June")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Juin %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "July")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Juillet %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "August")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Août %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "September")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Septembre %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "October")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Octobre %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "November")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Novembre %Y') }}
                                        </strong>
                                    @elseif($contrat->apprenant->dateNaissance->formatLocalized('%B') == "December")
                                        <strong>
                                            {{ $contrat->apprenant->dateNaissance->formatLocalized('%d Décembre %Y') }}
                                        </strong> 
                                    @endif
                                   <!-- <strong>20 Janvier 1996</strong> -->
                                </div>
                                <div class="col-sm-1">
                                    <strong class="paragraphe2" style="text-transform: uppercase">à </strong><br>
                                    <small>At</small>
                                </div>
                                <div class="col-sm-5 born">
                                    <strong class="paragraphe2">{{ $contrat->apprenant->lieuNaissance }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="line-height: 12px">
                        <div class="col-md-2 col-sm-2">
                            <p><strong>Le Diplôme de </strong><br><small>The degree of</small></p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>
                                <strong>
                                    MASTER PROFESSIONNEL 
                                </strong>
                            </p>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="row" style="line-height: 12px; margin-top: -5px">
                                <div class="col-md-2 col-sm-2">
                                    <p>
                                        <strong>Option</strong><br>
                                        <small>Option</small>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <p>
                                        <strong>{{ $contrat->specialite->title }}</strong><br>
                                        <span>{{ $speciality[$contrat->specialite->slug] }}</span>
                                    </p>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <p style="line-height: 12px">
                                        <strong>Mention:</strong>
                                        <span><b id="{{ 'mention-'. $contrat->id }}"></b></span>
                                        <br><small>Grade:</small><br><strong>Fait à Yaoundé, le</strong><br><small>Issued in Yaounde, on the
                                    </p>
                                </div>
                                <!-- <div class="col-md-2 col-sm-2">
                                    <p class="text-uppercase"><b id="{{ 'mention-'. $contrat->id }}"></b></p>
                                        </div>
                                    </div>
                                </div> -->
                    </div>

                    <div class="row" style="line-height: 12px; margin-top: -27px">
                        <div class="col-md-3 col-sm-3">
                            <p>
                                <small><b>L'impétrant</b></small><br>
                                <small>The Holder</small>
                            </p>
                        </div>  
                        <div class="col-md-4 col-sm-4">
                            <p>
                                <small><b>Le Recteur</small><br>
                                <small style="font-weight: normal">The Rector</small>
                            </p>
                        </div>
                        <div class="col-md-5 col-sm-5" style="margin-bottom: 20px">
                            <p style="text-align: center">
                                <small><b>
                                    Le Ministre d'Etat, Ministre de l'Enseignement Supérieur, <br>
                                    Chancelier des Ordres Académiques
                                </b></small><br>
                                <small>
                                        The Minister of State, Minister of Higher Education, <br>
                                        Chancellor of Academic Orders
                                </small>
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