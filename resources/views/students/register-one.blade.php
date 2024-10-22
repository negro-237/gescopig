@extends('layouts.register_app')
@section('content')
    <div class="tab-pane fade show active">
        <h3 class="register-heading">Informations personnelles</h3>
        <form action="{{ route('pre-register.one') }}" method="post">
            <div class="row register-form">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom" class="control-label">Nom<span class="required">*</span></label>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" class="form-control {!! $errors->has('nom') ? 'is-invalid' : '' !!}" placeholder="Ex: John" value="{{ $student['nom'] ?? '' }}" name="nom" />
                        {!! $errors->first('nom', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="prenom" class="control-label">Prenom<span class="required">*</span></label>
                        <input type="text" class="form-control {!! $errors->has('prenom') ? 'is-invalid' : '' !!}" placeholder="Ex: Doe" value="{{ $student['prenom'] ?? '' }}" name="prenom" id="prenom" />
                        {!! $errors->first('prenom', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="dateNaissance" class="control-label">Date de naissance<span class="required">*</span></label>
                        <input type="date" class="form-control {!! $errors->has('dateNaissance') ? 'is-invalid' : '' !!}"  placeholder="Ex: Date Naissance*" value="{{ $student['dateNaissance'] ?? '' }}" name="dateNaissance" id="dateNaissance" />
                        {!! $errors->first('dateNaissance', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="lieuNaissance" class="control-label">Lieu de naissance<span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Ex: Hopital la quintinie" value="{{ $student['lieuNaissance'] ?? '' }}" name="lieuNaissance" id="lieuNaissance" />
                        {!! $errors->first('lieuNaissance', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="sexe" class="control-label">Sexe<span class="required">*</span></label>
                        <div class="maxl">
                            <label class="radio inline"> 
                                <input type="radio" name="sexe" value="Homme" checked>
                                <span> Homme </span> 
                            </label>
                            <label class="radio inline"> 
                                <input type="radio" name="sexe" value="Femme">
                                <span>Femme </span> 
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lieuNaissance" class="control-label">Nationalité<span class="required">*</span></label>
                        {!! Form::select('nationalite', $countries, isset($student['nationalite']) ? $student['nationalite'] :  null, ['class' => 'form-control ' .($errors->has('nationalite') ? 'is-invalid' : ''), 'placeholder' => 'Sélectionnez la nationalité']) !!}
                        {!! $errors->first('nationalite', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="addresse" class="control-label">Addresse<span class="required">*</span></label>
                        <input type="text" class="form-control {!! $errors->has('addresse') ? 'is-invalid' : '' !!}" placeholder="Ex: Douala-Bonaberi*" value="{{ $student['addresse'] ?? '' }}" name="addresse" id="addresse" />
                        {!! $errors->first('addresse', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="tel" class="control-label">Téléphone<span class="required">*</span></label>
                        <input type="text" class="form-control {!! $errors->has('tel') ? 'is-invalid' : '' !!}" placeholder="Ex: 699205803*" value="{{ $student['tel'] ?? '' }}" name="tel" id="tel" />
                        {!! $errors->first('tel', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email<span class="required">*</span></label>
                        <input type="text" class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!}" placeholder="Ex: john.doe@gmail.com" value="{{ $student['email'] ?? '' }}" name="email" id="email" />
                        {!! $errors->first('email', '<small class="invalid-feedback">:message</small>') !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Suivant</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
@endsection