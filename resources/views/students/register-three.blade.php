@extends('layouts.register_app')
@section('content')
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="register-heading">Informations année scolaire</h3>
            <form action="{{ route('pre-register.three') }}" method="post">
                <div class="row register-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialite" class="control-label">Spécialité<span class="required">*</span></label>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {!! Form::select('specialite_id', $specialites, isset($student['specialite_id'] ) ? $student['specialite_id'] :  null, ['class' => 'form-control ' .($errors->has('specialite_id') ? 'is-invalid' : ''), 'placeholder' => 'Sélectionnez la spécialité']) !!}
                            {!! $errors->first('specialite_id', '<small class="invalid-feedback">:message</small>') !!}
                        </div>  
                        <div class="form-group">
                            <label for="cycle" class="control-label">Niveau<span class="required">*</span></label>
                            {!! Form::select('cycle_id', $cycles, isset($student['cycle_id']) ? $student['cycle_id'] :  null, ['class' => 'form-control ' .($errors->has('cycle_id') ? 'is-invalid' : ''), 'placeholder' => 'Sélectionnez la spécialité']) !!}
                            {!! $errors->first('cycle_id', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ville_id" class="control-label">Ville<span class="required">*</span></label>
                            {!! Form::select('ville_id', $cities->pluck('nom', 'id'), isset($student['ville_id']) ? $student['ville_id'] :  null, ['class' => 'form-control ' .($errors->has('ville_id') ? 'is-invalid' : ''), 'placeholder' => 'Sélectionnez la ville']) !!}
                            {!! $errors->first('ville_id', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group d-flex justify-content-end">
                            <div class="mx-3">
                                <a href="{{ route('pre-register.two') }}" class="btn btn-danger rounded">Précedent</a>
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