@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Rapport versement indemnités : {{ $contrat->enseignant->name }}</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('contratEnseignants.versements', [$contrat->id]) !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive results" id="contrats-table">
                    <thead>
                    <tr>
                        <th>Enseignement</th>
                        <th>Campus</th>
                        <th>Specialites</th>
                        <th>Semestre</th>
                        <th>mh Tot.</th>
                        <th>Mh Eff</th>
                        <th>Mh Rest.</th>
                        <th>Montant Tot.</th>
                        <th>NAP</th>
                        <th>Montant versé</th>
                        <th>Solde</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($tronc_communs as $tronc_commun)
                            <tr>
                                <td>
                                    {{ $tronc_commun->enseignements->first()->ecue->title }}
                                </td>
                                <td>                                    
                                    {{ $tronc_commun->enseignements->first()->ville->nom }}
                                </td>
                                <td>
                                    @foreach($tronc_commun->enseignements as $enseignement)
                                        {{ $enseignement->specialite->slug .' '. $enseignement->ecue->semestre->cycle->niveau .' ' }}
                                    @endforeach
                                </td>
                                <td>{{ $tronc_commun->enseignements->first()->ecue->semestre->title }}</td>
                                <td>{{ $mhTot = $tronc_commun->enseignements->first()->mhTotal }}</td>
                                <td>{{ $mhEff = $tronc_commun->enseignements->first()->mhEff }}</td>
                                <td>{{ $tronc_commun->enseignements->first()->mhTotal - $tronc_commun->enseignements->first()->mhEff }}</td>
                                <td>{{ $mt = (($tronc_commun->enseignements->first()->ecue->semestre->cycle->label == 'Licence') ? $contrat->mh_licence : $contrat->mh_master) * (($mhTot > $mhEff) ? $mhEff : $mhTot) }}</td>
                                <td>{{ $nap = $mt * (1 - 0.055) }}</td>
                                <td>{{ $pay = $tronc_commun->payments->sum('montant') }}</td>
                                <td>{{ $nap - $pay }}</td>
                                <td>
                                    <a href="{!! route('contratEnseignants.versements', [$tronc_commun->id, 'type='. 1]) !!}" class='btn btn-success btn-xs' title="enregistrer un paiement"><i class="glyphicon glyphicon-usd"></i></a>
                                    <a href="{!! route('contratEnseignants.details', [$tronc_commun->id, 'type='. 1]) !!}" class="btn btn-warning" title="Details des versements"><i class="glyphicon glyphicon-list-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($contrat->enseignements->where('tronc_commun_id', null) as $enseignement)
                            <tr>
                                <td>
                                    {{ $enseignement->ecue->title }}
                                </td>
                                <td>
                                    {{ !empty($enseignement->ville) ? $enseignement->ville->nom:'' }}
                                </td>
                                <td>
                                    {{ $enseignement->specialite->slug .' '. $enseignement->ecue->semestre->cycle->niveau }}
                                </td>
                                <td>{{ $enseignement->ecue->semestre->title }}</td>
                                <td>{{ $mhTot = $enseignement->mhTotal }}</td>
                                <td>{{ $mhEff = $enseignement->mhEff }}</td>
                                <td>{{ $enseignement->mhTotal - $enseignement->mhEff }}</td>
                                <td>{{ $mt = (($enseignement->ecue->semestre->cycle->label == 'Licence') ? $contrat->mh_licence : $contrat->mh_master) * (($mhTot > $mhEff) ? $mhEff : $mhTot) }}</td>
                                <td>{{ $nap = $mt * (1 - 0.055) }}</td>
                                <td>{{ $pay = $enseignement->payments->sum('montant') }}</td>
                                <td>{{ $nap - $pay }}</td>
                                <td>
                                    @can('pay teachers')
                                        <a href="{!! route('contratEnseignants.versements', [$enseignement->id, 'type='. 0]) !!}" class='btn btn-success' title="enregistrer un paiement"><i class="glyphicon glyphicon-usd"></i></a>
                                        <a href="{!! route('contratEnseignants.details', [$enseignement->id, 'type='. 0]) !!}" class="btn btn-warning" title="Details des versements"><i class="glyphicon glyphicon-list-alt"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td><h4>Total</h4></td>
                        <td id=""></td>
                        <td id=""></td>
                        <td id=""></td>
                        <td id=""></td>
                        <td id=""></td>
                        <td><strong id="total"></strong></td>
                        <td><strong id="nap"></strong></td>
                        <td><strong id="mt_verse"></strong></td>
                        <td><strong id="solde"></strong></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.22/api/sum().js"></script>


    <script>

        $(document).ready(function() {
            var table = $('#contrats-table').DataTable({
                responsive: true,
                dom:'Blfrtip',
                buttons:[
                    {extend:'copy', footer: true}, {extend:'excel', footer: true}, {extend:'pdf', footer: true}
                ],
                "columnDefs":[
                    {"orderable":false, "targets":3}
                ]
            });

            var total = table.column(6).data().sum();
            var nap = table.column(7).data().sum();
            var mt_verse = table.column(8).data().sum();
            var solde = table.column(9).data().sum();

            $('#total').html(total)
            $('#nap').html(nap)
            $('#mt_verse').html(mt_verse)
            $('#solde').html(solde)

            table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container() ))
        });
    </script>

@endsection

@section('css')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>

@endsection