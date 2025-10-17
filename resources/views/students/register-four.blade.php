@extends('layouts.register_app')
@section('content')
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="register-heading">Informations relatives aux parents</h3>
            <form action="{{ route('pre-register.four') }}" method="post">
                <div class="row register-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="p_name" class="control-label">Nom du parent<span class="required">*</span></label>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" class="form-control {!! $errors->has('p_name') ? 'is-invalid' : '' !!}" placeholder="Ex: ......" value="{{ $student['p_name'] ?? '' }}" name="p_name" id="p_name" />
                            {!! $errors->first('p_name', '<small class="invalid-feedback">:message</small>') !!}
                        </div>  
                        <div class="form-group">
                            <label for="p_profession" class="control-label">Profession<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('p_profession') ? 'is-invalid' : '' !!}" placeholder="Ex: Informaticien" value="{{ $student['p_profession'] ?? '' }}" name="p_profession" id="p_profession" />
                            {!! $errors->first('p_profession', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="p_phone" class="control-label">Portable<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('p_phone') ? 'is-invalid' : '' !!}" placeholder="Ex: ......" value="{{ $student['p_phone'] ?? '' }}" name="p_phone" id="p_phone" />
                            {!! $errors->first('p_phone', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="p_address" class="control-label">Addresse<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('p_address') ? 'is-invalid' : '' !!}" placeholder="Ex: Douala V - Logbessou" value="{{ $student['p_address'] ?? '' }}" name="p_address" id="p_address" />
                            {!! $errors->first('p_address', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="p_relation" class="control-label">Relation avec l'apprenant<span class="required">*</span></label>
                            <input type="text" class="form-control {!! $errors->has('p_relation') ? 'is-invalid' : '' !!}" placeholder="Ex: Pere" value="{{ $student['p_relation'] ?? '' }}" name="p_relation" id="p_relation" />
                            {!! $errors->first('p_relation', '<small class="invalid-feedback">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            <label for="p_fixe" class="control-label">Fixe</label>
                            <input type="text" class="form-control" placeholder="Ex: 245125347" value="{{ $student['p_fixe'] ?? '' }}" name="p_fixe" id="p_fixe" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group d-flex justify-content-end">
                            <div class="mx-3">
                                <a href="{{ route('pre-register.three') }}" class="btn btn-danger rounded">Précedent</a>
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