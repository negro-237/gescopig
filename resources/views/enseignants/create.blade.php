    @extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Enseignant
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'enseignants.store']) !!}

                        @include('enseignants.fields')

                        <div class="form-group col-xs-4">
                            {!! Form::label('mh_licence', 'Montant Horaire licence:') !!}
                            {!! Form::number('mh_licence', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-xs-4">
                            {!! Form::label('mh_master', 'Montant Horaire master:') !!}
                            {!! Form::number('mh_master', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-xs-4">
                            <label class="form-control-label" for="ville_id">Sélectionnez la ville</label>
                            <select id="ville_id" class="form-control" name="ville_id">
                                <option value="" selected>sélectionnez la ville</option>
                                @foreach($villes as $ville)
                                    <option value="{{$ville->id}}">{{$ville->nom}}</option>
                                @endforeach
                            </select>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
