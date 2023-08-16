@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-green">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$countAllContrats}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <small class="small-box-footer">Contrats enregistrés</small>
                    </div>
                </div>
                <div class="col-lg-3  col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-red">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$countReturnedContrats}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.returned')}}" class="small-box-footer">Contrats retournés</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-yellow">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$awaitingReturnContrats}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.awaiting-return')}}" class="small-box-footer">Contrats établis ou en attente de retour</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-blue">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$awaitingContrats}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.awaiting')}}" class="small-box-footer">Contrats en attente</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-green">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$goodLearner}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.learner')}}" class="small-box-footer">Apprenants en règle</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-red">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$registeredLearner}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.registered-learner')}}" class="small-box-footer">Apprenants inscrits</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-3 col-xs-6 clearfix">
                    <div class="small-box CG bg-yellow">
                        <div class="inner">
                            <h3>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$registeredLearnerWithMoratorium}}
                                    </font>
                                </font>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class=""></i>
                        </div>
                        <a href="{{route('contrats.registered-learner-with-moratorium')}}" class="small-box-footer">Apprenants inscrits avec moratoire</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="pull-left">Contrats de tous les apprenants enregistrés pour l'année en cours</h4>
                    <h4 class="pull-right">
                        <a class="btn btn-primary" href="{!! route('contrats.create') !!}">Add New</a>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>

                    @include('flash::message')

                    <div class="clearfix"></div>

                    <div class="box box-primary">
                        <div class="box-header"></div>
                        <div class="box-body">
                            <table class="table table-responsive results" id="contrats-table">
                                <thead>
                                    <tr>
                                        <th>Apprenant</th>
                                        <th>Spécialite</th>
                                        <th>Ville</th>
                                        <th>Téléphone</th>
                                        <th>Telephones Parents</th>
                                        <th>Année</th>
                                        <th>Statut Contrat</th>
                                        <th>Statut Apprenant</th>
                                        <th>Action</th>
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
                                        <td>{{ $contrat->academic_year->debut. '/' .$contrat->academic_year->fin }}</td>
                                        <td>{{ $contrat->state }}</td>
                                        <td>{{ $contrat->inscription_status }}</td>
                                        <td>
                                            {!! Form::open(['route' => ['contrats.destroy', $contrat->id], 'method' => 'delete']) !!}
                                            <div class='btn-group'>
                                            {{--                                    
                                                <a href="{!! route('contrats.show', [$contrat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                            --}}
                                                <a href="{!! route('contrats.edit', [$contrat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                @can('delete contrats')
                                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                @endcan
                                            </div>
                                            {!! Form::close() !!}
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
    <!--
    <section class="content-header">
        <h3 class="pull-left">Contrats de tous les apprenants enregistrés pour l'année en cours</h3>
        <h3 class="pull-right">
            <a class="btn btn-primary" href="{!! route('contrats.create') !!}">Add New</a>
        </h3>
    </section>
    <div class="content" style="border: 1px solid green">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
    -->
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
