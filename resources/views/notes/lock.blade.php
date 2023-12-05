@extends('layouts.app')

@section('content')
    
    <div class="content">
        
        <h1>
            Vérouiller/Débloquer les notes
        </h1>

        <div class="alert alert-success" id="alert" style="display:none">
            <strong></strong>
        </div>

        <div class="alert alert-success" id="alert-error" style="display:none">
            
        </div>

        <div class="box box-primary">
            <div class="box-body">

                    <div class="form-group col-sm-3">
                        {!! Form::label('academic_year', 'Selectionner l\'année académique:') !!}
                        {!! Form::select('academic_year',$academic,null,['class' => 'form-control']) !!}
                        {!! Form::token() !!}
                    </div>

                    <div class="form-group col-sm-3">
                        {!! Form::label('session', 'Selectionner la session:') !!}
                        {!! Form::select('session',['session1' => 'session1', 'session2' => 'session2'],null,['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-4">
                        {!! Form::label('level', 'Selectionner le niveau:') !!}
                        {!! Form::select('level',['1' => 'Licence 1', '2' => 'Licence 2', '3' => 'Licence 3', '4' => 'Master 1', '5' => 'Master 2'],null,['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::button('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
            </div>
        </div>
    </div>

    <script>

        const button = document.querySelector('button');

        button.addEventListener('click', function(event) {
            
            const xhttp = new XMLHttpRequest();
           
            const academic_year = document.querySelector('[name="academic_year"]').value;
            const token = document.querySelector('[name="_token"]').value;
            const session = document.querySelector('[name="session"]').value;
            const level = document.querySelector('[name="level"]').value;

            const url = "locked/"+session+"/"+academic_year+"/"+level;

            xhttp.onreadystatechange = function() {

                button.innerHTML = 'Sauvegarde en cours...';
                button.disabled = true; 

                if (this.readyState == 4 && this.status == 200) {

                    button.innerHTML = 'Sauvegarder';
                    const response = JSON.parse(this.responseText);
                    button.disabled = false;

                    if(response.success) {
                        document.querySelector('#alert').style.display = 'block';
                        document.querySelector('strong').innerHTML = response.message;
                    } else {
                        document.querySelector('#alert-error').style.display = 'block';
                        document.querySelector('#alert-error').innerHTML = response.message;
                    }

                }
            };

            xhttp.open("GET", url);
            xhttp.send(); 
        });

    </script>

@endsection

