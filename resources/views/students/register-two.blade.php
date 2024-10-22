@extends('layouts.register_app')
@section('content')
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="register-heading">Informations année scolaire</h3>
            <form action="{{ route('pre-register.two') }}" method="post">
                <div class="row register-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="region" class="control-label">Region d'origine<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('region') ? 'is-invalid' : '' !!}" placeholder="Ex: Centre" value="{{ $student['region'] ?? '' }}" name="region" id="region" />
                            {!! $errors->first('region', '<small class="invalid-feedback">:message</small>') !!}
                        </div>  
                        <div class="form-group">
                            <label for="civilite" class="control-label">Civilité<span class="required">*</span></label>
                            {!! Form::select('civilite', [
                                    'marié(e)' => 'Marié(e)',
                                    'célibataire' => 'Celibataire',
                                    'divorcé(e)' => 'Divorcé(e)',
                                    'veuf(ve)' => 'Veuf(ve)'
                                ]
                                , isset($student['civilite']) ? $student['civilite'] : null, ['class' => 'form-control ' .($errors->has('civilite') ? 'is-invalid' : ''), 'placeholder' => 'Sélectionnez votre statut']) !!}
                            {!! $errors->first('civilite', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="quartier" class="control-label">Quartier<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('quartier') ? 'is-invalid' : '' !!}" placeholder="Ex: Bonaberi ancienne route*" value="{{ $student['quartier'] ?? '' }}" name="quartier" id="quartier" />
                            {!! $errors->first('quartier', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="diplome" class="control-label">Niveau/Dernier diplôme<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('diplome') ? 'is-invalid' : '' !!}"  placeholder="Ex: Baccalaureat" value="{{ $student['diplome'] ?? '' }}" name="diplome" id="diplome" />
                            {!! $errors->first('diplome', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etablissement_provenance" class="control-label">Etablissement de Provenance<span class="required">*</span></label>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" class="form-control {!! $errors->has('etablissement_provenance') ? 'is-invalid' : '' !!}" placeholder="Ex: Lycee Mongo Beti" value="{{ $student['etablissement_provenance'] ?? '' }}" name="etablissement_provenance" id="etablissement_provenance" />
                            {!! $errors->first('etablissement_provenance', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="situation_professionnelle" class="control-label">Situation Professionnelle<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('situation_professionnelle') ? 'is-invalid' : '' !!}" placeholder="Ex: Contrôleur interne" value="{{ $student['situation_professionnelle'] ?? '' }}" name="situation_professionnelle" id="situation_professionnelle" />
                            {!! $errors->first('situation_professionnelle', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="entreprise" class="control-label">Entreprise<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('entreprise') ? 'is-invalid' : '' !!}" placeholder="Ex: Pigier Cameroun*" value="{{ $student['entreprise'] ?? '' }}" name="entreprise" id="entreprise" />
                            {!! $errors->first('entreprise', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group d-flex justify-content-end">
                            <div class="mx-3">
                                <a href="{{ route('pre-register.one') }}" class="btn btn-danger rounded">Précedent</a>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Suivant</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
    
@endsection