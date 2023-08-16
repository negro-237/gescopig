@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Specialite
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['tutors.store', $apprenant->id], 'method' => 'post']) !!}

                    @include('tutors.fields')

                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('tutors.index', [$apprenant->id]) !!}" class="btn btn-default">Cancel</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection