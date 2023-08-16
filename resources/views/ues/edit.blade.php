@extends('layouts.app')

@section('content')

    <div class="content col-md-10">
        <h1>{{ __('Modifier unité d\'enseignement') }}</h1>

        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            {{ Form::model($ue, ['route' => ['ues.update', $ue->id], 'method' => 'patch']) }}
            <div class="box-body">

                <div class="form-group col-sm-4">
                    {!! Form::label('title', 'Titre :') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'ue']) !!}
                </div>

                <div class="form-group col-sm-4">
                    {!! Form::label('code', 'Code :') !!}
                    {!! Form::text('code', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-4">
                    {!! Form::label('cat_ue_id', 'Categorie:') !!}
                    {!! Form::select('cat_ue_id',$catUes,null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a href="{!! route('ues.index') !!}" class="btn btn-default">Cancel</a>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>

@endsection

@section('css')

    <link rel="stylesheet" href="http://localhost/pigier/public/css/easy-autocomplete.min.css">

@endsection

@section('scripts')
    <script src="http://localhost/pigier/public/js/jquery.easy-autocomplete.min.js"></script>
    <script type="text/javascript">
        $(function(){
            var title = {
                data : {!! $ues !!},
                getValue: 'title',
                list: {
                    match:{
                        enabled: true
                    },
                    onClickEvent: function(e){

                        var id = $('#ue').getSelectedItemData().id;
                        window.location.href = 'http://gescopig.com/ues/' + id +'/edit';
                    }
                }
            };
            $('#ue').easyAutocomplete(title);
        });
    </script>

@endsection