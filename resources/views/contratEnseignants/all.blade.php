@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Etats des enseignants autorisés</h1>
        <h1 class="pull-right"></h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive results" id="contrats-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Nom Enseigant</th>
                            <th>Profession</th>
                            <th>Année académique</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contrat_enseignants as $contrat)
                            <tr>
                                <td>{{$contrat->enseignant()->pluck('titre')->implode(' ')}}</td>
                                <td>{{$contrat->enseignant()->pluck('name')->implode(' ')}}</td>
                                <td>{{$contrat->enseignant()->pluck('profession')->implode(' ')}}</td>
                                <td>{{$contrat->academic_year->debut}}-{{$contrat->academic_year->fin}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#printModal').on('show.bs.modal', function(e){
                var button = $(e.relatedTarget);
                var type = button.attr('id');
                var contrat = button.data('id')
                var modal = $(this);

                console.log(contrat)

                $('#send').click(function(e){
                    e.preventDefault();
                    console.log(3)
                    var signataire = $('#signataire').val()

                    var url = 'http://'+ ((window.location.host == 'pigier.test:81') ? window.location.host+'/public' : window.location.host) + '/contratEnseignants/contrats/'+contrat+'?signataire='+signataire;

                    window.open(url,'_blank', 'menubar=no, toolbar=no, width=1000px, height=600px')
                    window.location.reload();
                });
                console.log(window.location.host)
            });
        })
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.22/api/sum().js"></script>
    <script>

            $(function() {

                var table = $('#contrats-table').DataTable({
                    responsive: true,
                    dom:'Blfrtip',
                    // buttons:[
                    //     'copy', 'excel', 'pdf'
                    // ],
                    "columnDefs":[
                        {"orderable":false, "targets":3}
                    ]
                });
            });

    </script>

@endsection

@section('css')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.22/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.css"/>

    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.10.22/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script>--}}

@endsection