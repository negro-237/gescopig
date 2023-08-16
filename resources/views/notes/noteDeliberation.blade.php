@extends('layouts.app')

@section('content')

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <section class="content-header">
        {{ $contrat->specialite->slug. ' '. $contrat->cycle->niveau .' - '. $contrat->apprenant->nom. ' ' .$contrat->apprenant->prenom }}
    </section>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['url' => 'notes/deliberation/'.$sem.'/'.$type.'/'.$contrat->id]) !!}
                <table class="table table-responsive table-stripped">
                    <thead>
                    <tr>
                        <th>Ecue</th>
                        <th>Note</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($enseignements as $enseignement)

                        <tr>
                            <td>{{ $enseignement->ecue->title }}</td>
                            @if($type == 'session1')
                                <td>
                                    {{ Form::number($enseignement->id, $contrat->notes->where('enseignement_id', $enseignement->id)->first() ? $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del1 : 0, ['class' => 'form-control', 'step' => 'any', 'max' => 20 ]) }}
                                </td>
                            @elseif($type == 'session2')
                                <td>
                                    {{ Form::number($enseignement->id, $contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2, ['class' => 'form-control', ($contrat->notes->where('enseignement_id', $enseignement->id)->first()->del2 >= 10)? 'readonly' : '', 'step' => 'any', 'max' => 20]) }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer text-right m">
                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                <a href="{{ route('notes.deliberation', [$enseignement->ecue->semestre_id, $contrat->specialite_id]) }}" class="btn btn-default">
                    Back
                </a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection

   
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        
    $(function() {
        $('input[type="number"]').each(function() {
            $(this).on('blur', function(){
                if(parseFloat($(this).val()) > 20) {
                    $(this).css('border', 'red solid 1px')
                    swal({
                        title: "Erreur",
                        text: "Une note superieur à 20 vient d'être renseignée",
                        icon: "error"
                    });
                } else {
                    $(this).css('border', '')  
                }
            })
        })
    });

</script>