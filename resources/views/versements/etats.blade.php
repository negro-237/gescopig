@extends('layouts.app')

@section('content')
    <div class="clearfix"></div>

    <div class="clearfix"></div>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive results tablesorter" id="etats-apprenants">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Matricule</th>
                            <th>Spécialité</th>
                            <th>Ville</th>
                            <th>Année académique</th>
                            <th>Versements</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contrats as $c)
                            <tr>
                                <td>{{$c->apprenant->nom. ' ' .$c->apprenant->prenom}}</td>
                                <td>{{$c->apprenant->matricule}}</td>
                                <td>{{$c->specialite->slug}} {{$c->cycle->niveau}}</td>
                                <td>{{ !empty($c->ville) ? $c->ville->nom:'' }}</td>
                                <td>{{$c->academic_year->debut. '/' .$c->academic_year->fin}}</td>
                                <td>
                                    <ul>
                                        @foreach($c->versements as $v)
                                            <li>{{$v->montant}} {{$v->motif}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset("js/jquery.tablesorter.js") }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>

    <script>
        $(function(){
            var table = $('#etats-apprenants').DataTable({
                responsive: true,
                dom:'Blfrtip',
                buttons:[
                    'copy', 'excel', 'pdf'
                ],
                "columnDefs":[
                    {"orderable":false, "targets": 2}
                ]
            });

            table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container() ))
        })
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
@endsection()