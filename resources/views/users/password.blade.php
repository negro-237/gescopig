@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="col-md-8 col-md-offset-2">
            <!--
            @include('adminlte-templates::common.errors')            
            -->
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <h1><i class='fa fa-key'></i> Change password</h1>
            <br>

            <div class="box box-primary">
                <form method="POST" action="{{ route('user.password') }}" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-12 {!! $errors->has('oldPassword') ? 'has-error' : '' !!}">
                                <label for="oldPassword" class="control-label">Ancien mot de passe *</label>
                                {!! Form::password('oldPassword', ['class' => 'form-control', 'placeholder' => 'Ancien mot de passe']) !!}
                                {!! $errors->first('oldPassword', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 {!! $errors->has('password') ? 'has-error' : '' !!}">
                                <label for="password" class="control-label">Nouveau mot de passe *</label>
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nouveau mot de passe']) !!}
                                {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmer" class="control-label">Confirmer *</label>
                                {!! Form::password('confirmer', ['class' => 'form-control', 'placeholder' => 'Confirmation mot de passe']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ Form::submit('Save', array('class' => 'btn btn-primary pull-right')) }}
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

