@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Apprenant
        </h1>
   </section>
    <div class="row">
        <div class="content col-md-12">
            @include('adminlte-templates::common.errors')

            {!! Form::model($apprenant, ['route' => ['apprenants.update-medical', $apprenant->id], 'method' => 'patch']) !!}

                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('nom', 'Nom * :') !!}
                                        {!! Form::text('nom', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>

                                    <div class="form-group col-xs-4">
                                        {!! Form::label('prenom', 'Prenom * :') !!}
                                        {!! Form::text('prenom', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>

                                    <div class="form-group col-xs-4">
                                        {!! Form::label('sexe', 'Sexe * :') !!}
                                        {!! Form::select('sexe',['Homme'=>'Homme', 'Femme'=>'Femme'],isset($apprenant)? $apprenant->sexe : null,['class' => 'form-control', 'placeholder' => 'choisissez le sexe de l\'apprenant', 'disabled']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('dateNaissance', 'Date de naissance * :') !!}
                                        {!! Form::date('dateNaissance', isset($apprenant) ? Carbon\Carbon::parse($apprenant->dateNaissance) : null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('lieuNaissance', 'Lieu de Naissance * :') !!}
                                        {!! Form::text('lieuNaissance', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('nationalite', 'Nationalite * :') !!}
                                        {!! Form::text('nationalite', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>
                                <!--
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('addresse', 'Adresse * :') !!}
                                        {!! Form::text('addresse', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('tel', 'Tel * :') !!}
                                        {!! Form::text('tel', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('email', 'Email * :') !!}
                                        {!! Form::email('email', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('region', 'Region d\'origine * :') !!}
                                        {!! Form::text('region', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('civilite', 'Civilite * :') !!}
                                        {!! Form::select('civilite',
                                         ['marié(e)' => 'Marié(e)', 'célibataire' => 'Celibataire', 'divorcé(e)' => 'Divorcé(e)',
                                          'veuf(ve)' => 'Veuf(ve)'], isset($apprenant)? $apprenant->civilite : null, ['class' => 'form-control', 'placeholder' => 'sélectionnez le statut', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('quartier', 'Quartier * :') !!}
                                        {!! Form::text('quartier', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('diplome', 'Niveau / Dernier diplôme * :') !!}
                                        {!! Form::text('diplome', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                    
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('etablissement_provenance', 'Etablissement de Provenance * :') !!}
                                        {!! Form::text('etablissement_provenance', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('situation_professionnelle', 'Situation Professionnelle * :') !!}
                                        {!! Form::text('situation_professionnelle', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('entreprise', 'Entreprise :') !!}
                                        {!! Form::text('entreprise', null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>
                                -->
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('academic_year_id', 'Année Académique * :') !!}
                                        {!! Form::select('academic_year_id',$academicYears, isset($apprenant)? $apprenant->academic_year_id : null, ['class' => 'form-control', 'placeholder' => 'sélectionnez l\'année', 'disabled']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @can('medical-file')
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <button type="button" class="Show btn btn-default">Afficher</button>
                        <button type="button" class="Hide btn btn-default" style="display:none;">Masquer</button>
                    </div>
                </div>
                @endcan

                <div class="box box-primary" id="target" style="display:none; border:1px solid green">
                    <div class="box-body">

                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.Show').click(function() {
                $('#target').show();
                $('.Show').hide();
                $('.Hide').show();
            });
            $('.Hide').click(function() {
                $('#target').hide();
                $('.Show').show();
                $('.Hide').hide();
            });
        });
    </script>
@endsection
