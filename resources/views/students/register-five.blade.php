@extends('layouts.register_app')
@section('content')
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="register-heading">Documents</h3>
            @include('flash::message')
            <form action="{{ route('pre-register.five') }}" method="post"  enctype="multipart/form-data">
                <div class="row register-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file_birth" class="control-label">Acte de Naissance<span class="required">*</span></label>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {!! Form::file('file_birth', ['class' => 'form-control ' .($errors->has('file_birth') ? 'is-invalid' : ''), 'placeholder' => 'Ajouter votre acte de naissance']) !!}
                            {!! $errors->first('file_birth', '<small class="invalid-feedback">:message</small>') !!}
                            <small id="file_birth" class="form-text text-muted">Les fichiers acceptés sont: jpg,png,pdf et la taille maximale est de 1Mo</small>
                        </div>  
                        <div class="form-group">
                            <label for="file_cni" class="control-label">Recto carte d'identité ou Passport<span class="required">*</span></label>
                            {!! Form::file('file_cni', ['class' => 'form-control ' .($errors->has('file_cni') ? 'is-invalid' : ''), 'placeholder' => 'Ajoutez le recto de votre cni']) !!}
                            {!! $errors->first('file_cni', '<small class="invalid-feedback">:message</small>') !!}
                            <small id="file_cni" class="form-text text-muted">Les fichiers acceptés sont: jpg,png,pdf et la taille maximale est de 1Mo</small>
                        </div>
                        <div class="form-group">
                            <label for="file_diploma" class="control-label">Dernier diplome<span class="required">*</span></label>
                            {!! Form::file('file_diploma', ['class' => 'form-control ' .($errors->has('file_diploma') ? 'is-invalid' : ''), 'placeholder' => 'Ajoutez votre diplome']) !!}
                            {!! $errors->first('file_diploma', '<small class="invalid-feedback">:message</small>') !!}
                            <small id="file_diploma" class="form-text text-muted">Les fichiers acceptés sont: jpg,png,pdf et la taille maximale est de 1Mo</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file_cni_verso" class="control-label">Verso carte d'identité ou Passport<span class="required">*</span></label>
                            {!! Form::file('file_cni_verso', ['class' => 'form-control ' .($errors->has('file_cni_verso') ? 'is-invalid' : ''), 'placeholder' => 'Ajoutez le verso de votre cni']) !!}
                            {!! $errors->first('file_cni_verso', '<small class="invalid-feedback">:message</small>') !!}
                            <small id="file_cni_verso" class="form-text text-muted">Les fichiers acceptés sont: jpg,png,pdf et la taille maximale est de 1Mo</small>
                        </div>
                        <div class="form-group">
                            <label for="file_receipt" class="control-label">Récu de versement<span class="required">*</span></label>
                            {!! Form::file('file_receipt', ['class' => 'form-control ' .($errors->has('file_receipt') ? 'is-invalid' : ''), 'placeholder' => 'Ajoutez votre réçu de versement']) !!}
                            {!! $errors->first('file_receipt', '<small class="invalid-feedback">:message</small>') !!}
                            <small id="file_receipt" class="form-text text-muted">Les fichiers acceptés sont: jpg,png,pdf et la taille maximale est de 1Mo</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group d-flex justify-content-end">
                            <div class="mx-3">
                                <a href="{{ route('pre-register.four') }}" class="btn btn-danger rounded">Précedent</a>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
    
@endsection