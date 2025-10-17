<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Releve de Notes</title>

        <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
        <style>
            div .logo{
                width: 40%;
                height: 45%;
            }

            @media print{
                .footer{
                    page-break-after: always;
                    position: absolute;
                    bottom: 0;
                    width: 100%;
                }
                .table-bordered> tbody>tr>td,
                .table-bordered> thead>tr>th,
                .table-bordered>tbody>tr>th{
                    border: 1px solid #000000 !important;
                }
                
                
            }
            #logo_pigier{
                width: 50%;
            }
            .header p{
                font-size: 80%;
                margin-bottom: 3px;
            }

            .infos tr{
                font-size: 11px;
            }
            .notes-table tr{
                font-size: 90%;
                border: 1px solid #000000;!important;
            }

            .table-bordered> tbody>tr>td,
            .table-bordered> thead>tr>th,
            .table-bordered>tbody>tr>th{
                border: 1px solid #000000;!important;
            }

            .table-bordered>thead>tr.ue{
                background-color: #D3D3D3;
            }
            /*.resultats{*/
                /*background-color: #a6a28c;*/
            /*}*/

            .infos{
                border-: 2px 0px;

            }

            .legende {
                text-decoration: underline; 
                line-height: 1px
            }

            .text-4 {
                font-size: 14px;
                font-weight: bold
            }
        </style>
    </head>

    <body class="skin-blue sidebar-mini fixed">

        <div class="wrapper col-xs-10">
            <div class="content-wrapper">
                <section class="content container-fluid .page-break" id="rnr">
                    <div class="container-fluid">

                        <div class="header row fixed-top bg-info">
                            <div class="col-lg-12">

                                <div class="row" style="border:1px solid green">
                                    <div class="col-xs-3 pull-left">
                                        <div class="row"><img src="{{ url('images/essec.jpg') }}" class="logo" alt="Accueil"></div>
                                        <div class="row">
                                            <p><small>BP: 1931 Douala-Cameroun</small></p>
                                            <p><small>Tél: +237 233 40 53 41</small></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="row">
                                            <div class="col-xs-6 text-center mt-5 pt-3">
                                                <p>REPUBLIQUE DU CAMEROUN</p>
                                                <p><small>Paix - Travail - Patrie</small></p>
                                                <p>MINISTERE DE L'ENSEIGNEMENT SUPERIEUR</p>
                                                <p>UNIVERSITÉ DE DOUALA</p>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <p>REPUBLIC OF CAMEROON</p>
                                                <p><small>Peace - Work - Fatherland</small></p>
                                                <p>MINISTRY OF HIGHER EDUCATION</p>
                                                <p>THE UNIVERSITY OF DOUALA</p>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h4><strong>Relevé de notes et résultats / Transcript</strong></h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 pull-right">
                                        <div class="row"><img src="{{ url('images/logo_pigier.jpg') }}" class=" pull-right" alt="Pigier logo" id="logo_pigier" style="width:197px; height:108px"></div>
                                        <div class="row pull-right text-right">
                                            <p><small><strong>BP:</strong> 1931 Douala-Cameroun</small></p>
                                            <p><small><strong>Tél:</strong> +237 243 85 83 46</small></p>
                                            <p><small><strong>Email:</strong> pigierdouala@pigiercam.com /<br> pigiercameroun@pigiercam.com</small></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row " id="student-infos">
                                    <div class="col-xs-8 infos">
                                        <div class="row">
                                            <table class="pull-left">
                                                <tr>
                                                    <th>Identifiant-matricule/ Id-Registration Number: </th>
                                                    <td><span class="text-4">{{ $contrat->apprenant->matricule }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Nom(s) et Prenom(s) / Name(s) and Surname(s) : </th>
                                                    <td><span class="text-4">{{ $contrat->apprenant->nom. ' ' .$contrat->apprenant->prenom }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Parcours / Cycle Degree: </th>
                                                    <td><span class="text-4">{{ $enseignements->first()->ecue->semestre->cycle->label .' '. (($enseignements->first()->ecue->semestre->cycle->label == 'Master') ? 'Professionnel' : 'Professionnelle') }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Specialité et niveau/ Speciality and Level: </th>
                                                    <td><span class="text-4">{{ $contrat->specialite->title. ' - '.$contrat->specialite->slug. (($enseignements->first()->ecue->semestre->cycle->label == 'Licence') ? '-L' : ' ') .$enseignements->first()->ecue->semestre->cycle->niveau }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Semestre/ Semester:</th>
                                                    <td><span class="text-4">{{ $enseignements->first()->ecue->semestre->title }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Session/ Session:</th>
                                                    <!-- <td><span class="text-4">session 1</span></td> -->
                                                    <td><span class="text-4">{{ substr_replace($session, ' ', strlen($session)-1,0) }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-4 infos ">
                                        <div class="row">
                                            <table class="pull-right">
                                                <tr>
                                                    <th class="text-right">Réf. du contrat / Contract Reference : </th>
                                                    <td class="text-left"><span class="text-4">{{ $academicYear->fin. '-' .$contrat->id }} </span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right">Année d'inscription / Registration year : </th>
                                                    <td class="text-left"><span class="text-4">{{ $contrat->apprenant->academic_year->debut. ' ' .$contrat->apprenant->academic_year->fin }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right">Ref. du relevé / Transcript Ref : </th>
                                                    <td class="text-left"><span class="text-4">{{ $academicYear->fin }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right">Année académique / Academic Year:</th>
                                                   <!--  <td class="text-left"><span class="text-4">2023-2024</span></td> -->
                                                    <td class="text-left"><span class="text-4">{{ $academicYear->debut }}-{{ $academicYear->fin }} </span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>                            
                        </div>

                        <div class="row notes-table">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="border: 1px solid #006800" class="ue">
                                    <th>Code</th>
                                    <th colspan="2">Unité d'Enseigement (UE) /Eléments constitutifs de l'UE (ECUE)</th>
                                    <th>Valeur CECT</th>
                                    <th>*CECT Aquis</th>
                                    <th>Note Ecue</th>
                                    <th>Crédit ECUE</th>
                                    <th>Note Pondérée</th>
                                    <th>Grade Point</th>
                                    <th>Grade</th>

                                </tr>
                                <tr></tr>
                                </thead>
                                <tbody>

                                    @foreach($ues as $ue)
                                        <tr class="">
                                            {{--Nombre de lignes dependent du nombre d'ecues de l'ue + 2--}}
                                            <td rowspan="{{ $enseignements->where('ue_id', $ue->id)->count()+2 }}"><strong>{{ $ue->code. $specialityCode. $semestre->id }}</strong></td>
                                            <td colspan="2" class="text-primary"><strong>{{ $ue->title }}</strong></td>
                                            <td><strong>{{ $enseignements->where('ue_id', $ue->id)->sum('credits') }}</strong></td>
                                            <td><strong>{{ $contrat->ue_infos->where('ue_id', $ue->id)->first()->creditObt }}</strong></td>
                                            <td colspan="5"></td>
                                        </tr>
                                        @foreach($enseignements as $enseignement)
                                            @if($enseignement->ue_id == $ue->id)
                                                <tr>
                                                    <td colspan="4">{{ $enseignement->ecue->title }}</td>
                                                    <td>
                                                        @if($session == 'session1')
                                                            {!! number_format($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1, 2, ',', ' ') !!}
                                                        @elseif($session == 'session2')
                                                            {!! ($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 > $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1) ? $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 : $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 !!}
                                                        @endif
                                                    </td>
                                                    <td>{{ $enseignement->credits }}</td>
                                                    <td>
                                                        @if($session == 'session1')
                                                            {!! number_format($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 * $enseignement->credits, 2, ',', ' ') !!}
                                                        @elseif($session == 'session2')
                                                            {!! (($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 > $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1) ? $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 : $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1) * $enseignement->credits !!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($session == 'session1')
                                                            @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 21 )
                                                                <span>4.00</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 18)
                                                                <span>4.00</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 16)
                                                                <span>3.70</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 15)
                                                                <span>3.30</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 14)
                                                                <span>3.00</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 13)
                                                                <span>2.70</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 12)
                                                                <span>2.30</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 11)
                                                                <span>2.00</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 10)
                                                                <span>1.70</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 9)
                                                                <span>1.30</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 8)
                                                                <span>1.00</span>
                                                            @else
                                                                <span>0.00</span>
                                                            @endif
                                                        @elseif($session == 'session2')
                                                            @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 > $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1)
                                                                @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 21 )
                                                                    <span>4.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 18)
                                                                    <span>4.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 16)
                                                                    <span>3.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 15)
                                                                    <span>3.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 14)
                                                                    <span>3.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 13)
                                                                    <span>2.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 12)
                                                                    <span>2.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 11)
                                                                    <span>2.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 10)
                                                                    <span>1.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 9)
                                                                    <span>1.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 8)
                                                                    <span>1.00</span>
                                                                @else
                                                                    <span>0.00</span>
                                                                @endif
                                                              
                                                            @else
                                                                @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 21 )
                                                                    <span>4.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 18)
                                                                    <span>4.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 16)
                                                                    <span>3.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 15)
                                                                    <span>3.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 14)
                                                                    <span>3.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 13)
                                                                    <span>2.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 12)
                                                                    <span>2.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 11)
                                                                    <span>2.00</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 10)
                                                                    <span>1.70</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 9)
                                                                    <span>1.30</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 8)
                                                                    <span>1.00</span>
                                                                @else
                                                                    <span>F</span>
                                                                @endif
                                                            @endif
                                                        @endif  
                                                    </td>
                                                    <td>
                                                        @if($session == 'session1')
                                                            @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 21 )
                                                                <span>A+</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 18)
                                                                <span>A</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 16)
                                                                <span>A-</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 15)
                                                                <span>B+</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 14)
                                                                <span>B</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 13)
                                                                <span>B-</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 12)
                                                                <span>C+</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 11)
                                                                <span>C</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 10)
                                                                <span>C-</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 9)
                                                                <span>D+</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 8)
                                                                <span>D</span>
                                                            @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 6 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 7)
                                                                <span>E</span>
                                                            @else
                                                                <span>F</span>
                                                            @endif
                                                        @elseif($session == 'session2')
                                                            @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 > $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1)
                                                                @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 21 )
                                                                    <span>A+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 18)
                                                                    <span>A</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 16)
                                                                    <span>A-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 15)
                                                                    <span>B+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 14)
                                                                    <span>B</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 13)
                                                                    <span>B-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 12)
                                                                    <span>C+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 11)
                                                                    <span>C</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 10)
                                                                    <span>C-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 9)
                                                                    <span>D+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 8)
                                                                    <span>D</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 6 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 < 7)
                                                                    <span>E</span>
                                                                @else
                                                                    <span>F</span>
                                                                @endif
                                                              
                                                            @else
                                                                @if($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 18 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 21 )
                                                                    <span>A+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 16 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 18)
                                                                    <span>A</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 15 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 16)
                                                                    <span>A-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 14 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 15)
                                                                    <span>B+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 13 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 14)
                                                                    <span>B</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 12 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 13)
                                                                    <span>B-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 11 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 12)
                                                                    <span>C+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 10 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 11)
                                                                    <span>C</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 9 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 10)
                                                                    <span>C-</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 8 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 9)
                                                                    <span>D+</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 7 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 8)
                                                                    <span>D</span>
                                                                @elseif($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 >= 6 && $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 < 7)
                                                                    <span>E</span>
                                                                @else
                                                                    <span>F</span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr class="resultats">
                                            <td class="text-right">Résultat UE</td>
                                            <td class="text-primary"><strong>{{ $contrat->ue_infos->where('ue_id', $ue->id)->first()->mention }}</strong></td>
                                            <td colspan="2" class="text-right">Moyenne UE</td>
                                            <td class="text-primary">{{ number_format($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne, 2, ',', ' ') }}</td>
                                            <td></td>
                                            <td>{{ number_format($contrat->ue_infos->where('ue_id', $ue->id)->first()->totalNotes, 2, ',', ' ') }}</td>
                                            <td>
                                                @if($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 18 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 21 )
                                                    <span>4.00</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 16 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 18)
                                                    <span>4.00</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 15 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 16)
                                                    <span>3.70</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 14 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 15)
                                                    <span>3.30</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 13 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 14)
                                                    <span>3.00</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 12 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 13)
                                                    <span>2.70</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 11 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 12)
                                                    <span>2.30</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 10 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 11)
                                                    <span>2.00</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 9 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 10)
                                                    <span>1.70</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 8 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 9)
                                                    <span>1.30</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 7 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 8)
                                                    <span>1.00</span>
                                                @else
                                                    <span>0.00</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 18 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 21 )
                                                    <span>A+</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 16 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 18)
                                                    <span>A</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 15 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 16)
                                                    <span>A-</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 14 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 15)
                                                    <span>B+</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 13 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 14)
                                                    <span>B</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 12 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 13)
                                                    <span>B-</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 11 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 12)
                                                    <span>C+</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 10 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 11)
                                                    <span>C</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 9 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 10)
                                                    <span>C-</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 8 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 9)
                                                    <span>D+</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne >= 7 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->moyenne < 8)
                                                    <span>D</span>
                                                @elseif($contrat->ue_infos->where('ue_id', $ue->id)->first()->totalNotes >= 6 && $contrat->ue_infos->where('ue_id', $ue->id)->first()->totalNotes < 7)
                                                    <span>E</span>
                                                @else
                                                    <span>F</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <p class="fixed-top pull-left">Décision:
                                    <strong>
                                        {{ $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->mention }}
                                    </strong>
                                </p><br><br><br>
                                <p class="pull-left">Observations:</p><br><br><br>
                                <p class="pull-left">Fait à Douala le : </p>
                            </div>

                            <div class="col-xs-6 text-left">
                                <table class="table table-bordered">

                                        <!-- <tr>
                                            <th class="text-right">Nombre d'UE Validées: </th>
                                            <td>{{ $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->nbUeValid }}</td>
                                        </tr> -->
                                        <tr>
                                            <th class="text-right">Total CECT Acquis: </th>
                                            <td>{{ $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->creditObt }} / 30</td>
                                        </tr>

                                        <th class="text-right">Total notes Obtenues: </th>
                                        <td>{{ number_format($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->totalNotes, 2, ',',' ') }}/600</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Moyenne Semestrielle: </th>
                                        <td>{{ number_format($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne, 2, ',',' ') }}/20</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Grade Point: </th>
                                        <td>
                                            @if($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 16)
                                                <span>4.00</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 15 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 16)
                                                <span>3.70</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 14 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 15)
                                                <span>3.30</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 13 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 14)
                                                <span>3.00</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 12 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 13)
                                                <span>2.70</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 11 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 12)
                                                <span>2.30</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 10 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 11)
                                                <span>2.00</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 9 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 10)
                                                <span>1.70</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 8 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 9)
                                                <span>1.30</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 7 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 8)
                                                <span>1.0</span>
                                            @else
                                                <span>0.00</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-right">Grade: </th>
                                        <td>
                                            @if($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 18 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 21 )
                                                    <span>A+</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 16 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 18)
                                                    <span>A</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 15 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 16)
                                                <span>A-</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 14 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 15)
                                                <span>B+</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 13 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 14)
                                                <span>B</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 12 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 13)
                                                <span>B-</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 11 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 12)
                                                <span>C+</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 10 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 11)
                                                <span>C</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 9 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 10)
                                                <span>C-</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 8 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 9)
                                                <span>D+</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 7 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 8)
                                                <span>D</span>
                                            @elseif($contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne >= 6 && $contrat->semestre_infos->where('semestre_id', $semestre->id)->first()->moyenne < 7)
                                                <span>E</span>
                                            @else
                                                <span>F</span>
                                            @endif
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="pull-left"><strong><u>Le Directeur de L'ESSEC/ The Director of ESSEC</u></strong></p><br><br><br><br>
                                <p class="pull-left"><strong>Pr André Modeste ABATE</strong></p>
                            </div>
                            <div class="col-xs-6">
                                <p class="text-right"><strong><u>Le Responsable Académique/ The Head Teacher:</u></strong></p><br><br>
                                <p class="text-right"><strong>Pr Germain NDJIEUNDE</strong></p>
                            </div>
                        </div>

                    </div>
                    <div class="container-fluid footer fixed-bottom">

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- <p class="">*CECT : Crédit d'Evaluation Capitalisable et Transférable</p> -->
                                <p class="">
                                    <small>
                                        <span><b>Légende:</b></span>
                                        <span>A+=Excellent/Excellent,</span>
                                        <span>A=Très Bien/Very Good,</span>
                                        <span>A-=Bien/Good,</span>
                                        <span>B+=Bien/Good,</span>
                                        <span>B/B-=Assez Bien/Fair Good,</span>
                                        <span>C+/C=Passable/Average,</span><br>
                                        <span>C-=Insuffisant/Poor,</span>
                                        <span>D+=Médiocre/Below Average,</span>
                                        <span>D=Faible/Weak,</span>
                                        <span>E=Très Faible/Very Weak,</span>
                                        <span>F=Nul/Null</span><br>
                                        <span>CECT=Crédit d'Evaluation Capitalisable et Transférable</span>
                                    </small>
                                </p>
                                <p class="text-left"><small>Il n'est délivré qu'un seul relevé de notes qui ne tient lieu en aucun cas d'attestation de diplôme. Aucun duplicata ne sera fourni.</small></p>
                            </div>
                            <div class="col-xs-6"><h5 class="text-center"><strong>Pigier Cameroun, Première Ecole Centre Agréée d'Examens Microsoft Office au Cameroun</strong></h5></div>
                            <div class="col-xs-3"><img src="{{ url('images/office-specialist.jpg') }}" alt="logo microsoft" class="logo"></div>
                        </div>

                        <div class="bg-primary">
                            <p class="text-center">UNE ECOLE DU GROUPE EDUSERVICES - FRANCE</p>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <button class="btn btn-primary" onclick="imprimer('rnr')">Imprimer</button>
            </div>
        </div>

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
        </script>
    </body>

</html>