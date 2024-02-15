@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Creation Medicale
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @if($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'medicals.store']) !!}

                        @include('medicals.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection