@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">

            <div class="row">
                <div class="col-md-12">
                    <h4 class="pull-left">Liste des apprenants en règle pour l'année en cours</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <table class="table table-responsive results" id="contrats-table">
                                <thead>
                                    <tr>
                                        <th>Nom Apprenant</th>
                                        <th>Specialite</th>
                                        <th>Ville</th>
                                        <th>Telephone</th>
                                        <th>Telephones Parents</th>
                                        <th>Annee Academique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contrats as $contrat)
                                    <tr>
                                        <td>{{ $contrat->apprenant->nom. ' ' .$contrat->apprenant->prenom }}</td>
                                        <td>{{ $contrat->specialite->slug. ' ' .$contrat->cycle->niveau }}</td>
                                        <td>{{ !empty($contrat->ville) ? $contrat->ville->nom:'' }}</td>
                                        <td>{{ $contrat->apprenant->tel }}</td>
                                        <td>
                                            @foreach($contrat->apprenant->tutors as $tutor)
                                                {{ $tutor->tel_mobile }}<br/>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $contrat->academic_year->debut. '/' .$contrat->academic_year->fin }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="http://localhost/pigier/public/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#contrats-table').DataTable({
                responsive: true,
                dom:'Blfrtip',
                buttons:[
                    'copy', 'excel', 'pdf'
                ],
                "columnDefs":[
                    {"orderable":false, "targets":5}
                ]
            });
            table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container() ))
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
    <style>
        .results tr[visible='false'], .no-result{
            display: none;
        }
        .results tr[visible='true']{
            display: table-row;
        }
        .counter{
            padding: 8px;
            color: #acacac;
        }
    </style>
@endsection