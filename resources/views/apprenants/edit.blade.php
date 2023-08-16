@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Apprenant
        </h1>
   </section>
    <div class="row">
        <div class="content col-md-12">
            @include('adminlte-templates::common.errors')

            {!! Form::model($apprenant, ['route' => ['apprenants.update', $apprenant->id], 'method' => 'patch']) !!}

                @include('apprenants.fields')

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.Show').click(function() {
                $('#target').show();
                $('.Show').hide();
                $('.Hide').show();
            });
            $('.Hide').click(function() {
                $('#target').hide();
                $('.Show').show();
                $('.Hide').hide();
            });

            $('.Show1').click(function() {
                $('#target1').show();
                $('.Show1').hide();
                $('.Hide1').show();
            });
            $('.Hide1').click(function() {
                $('#target1').hide();
                $('.Show1').show();
                $('.Hide1').hide();
            });

            $('.Show2').click(function() {
                $('#target2').show();
                $('.Show2').hide();
                $('.Hide2').show();
            });
            $('.Hide2').click(function() {
                $('#target2').hide();
                $('.Show2').show();
                $('.Hide2').hide();
            });

            $('.Show3').click(function() {
                $('#target3').show();
                $('.Show3').hide();
                $('.Hide3').show();
            });
            $('.Hide3').click(function() {
                $('#target3').hide();
                $('.Show3').show();
                $('.Hide3').hide();
            });
        });
    </script>
@endsection
