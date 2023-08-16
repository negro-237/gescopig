@extends('layouts.app')

@section('css')
    <style>
        .notif {
            color: red
        }

        .bold {
            font-weight: bold
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Apprenant
        </h1>
    </section>
    <div class="row">
        <div class="content col-md-12">
            @include('adminlte-templates::common.errors')

            {!! Form::open(['route' => 'apprenants.store', 'id' => 'form']) !!}

                @include('apprenants.fields')

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            var elem = $('#parent1').clone();
            var form = $('#form')
            var i = 1;
            $('#ajouter').click(function(e){
                e.preventDefault();
                var clone = elem;
                console.log(clone)
                ++i;
                clone.attr('id','parent' + i);
                clone.find('h3').html('Informations du parent'+i)
                clone.find('.nameLabel').attr('for', 'name'+i).val('');
                clone.find('.nameInput').attr('name', 'name'+i).val('');

                clone.find('.professionLabel').attr('for', 'profession'+i).val('');
                clone.find('.professionInput').attr('name', 'profession'+i).val('');

                clone.find('.addresseLabel').attr('for', 'addresse'+i).val('');
                clone.find('.addresseInput').attr('name', 'addresse'+i).val('');

                clone.find('.tel_mobileLabel').attr('for', 'tel_mobile'+i).val('');
                clone.find('.tel_mobileInput').attr('name', 'tel_mobile'+i).val('');

                clone.find('.tel_bureauLabel').attr('for', 'tel_bureau'+i).val('');
                clone.find('.tel_bureauInput').attr('name', 'tel_bureau'+i).val('');

                clone.find('.tel_fixeLabel').attr('for', 'tel_fixe'+i).val('');
                clone.find('.tel_fixeInput').attr('name', 'tel_fixe'+i).val('');

                clone.find('.typeLabel').attr('for', 'type'+i).val('');
                clone.find('.typeInput').attr('name', 'type'+i).val('');

                clone.find('.typeLabel').attr('for', 'type'+i).val('');
                clone.find('.typeInput').attr('email', 'type'+i).val('');

                clone.insertBefore('.button-container')
                elem = clone.clone()
            })

            $('#save').click(function(e){
                e.preventDefault();
                var input = '<input type="hidden" value="'+i+'" name="number"/>';
                $('#parent1').append(input);
                console.log(input);
                form.submit();
            })

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
        })
    </script>
@endsection
