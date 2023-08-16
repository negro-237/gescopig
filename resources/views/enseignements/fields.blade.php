
<div class="form-group col-sm-6">
    {!! Form::label('ecue_id', 'Ecue:') !!}
    {!! Form::select('ecue_id',$ecues, isset($enseignement) ? $enseignement->ecue->id : null,['class' => 'form-control', 'placeholder' => '', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('contrat_enseignant_id', 'Enseignant:') !!}
    {!! Form::select('contrat_enseignant_id',$enseignants, isset($enseignement) ? $enseignement->contratEnseignant->id : null,['class' => 'form-control', 'placeholder' => '', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group col-sm-6">
    {{ Form::label('credits', 'Credits') }}
    {{ Form::number('credits', isset($enseignement)? $enseignement->credits : null, ['class' => 'form-control']) }}
</div>

<div class="form-group col-sm-6">
    {{ Form::label('ue_id', 'Unite d\'enseignement') }}
    {{ Form::select('ue_id', $ues, isset($enseignement)? $enseignement->ue_id : null, ['class' => 'form-control']) }}
</div>

<!-- Datedebutprevue Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dateDebut', 'Date de Debut du cours:') !!}
    {!! Form::date('dateDebut', isset($enseignement) ? $enseignement->dateDebut : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>



<!-- Datefinprevue Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dateFin', 'Date de fin du cours:') !!}
    {!! Form::date('dateFin', isset($enseignement) ? $enseignement->dateFin : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>



<!-- Masse horaire total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mhTotal', 'Mhtotal:') !!}
    {!! Form::number('mhTotal', isset($enseignement) ? $enseignement->mhTotal : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group col-sm-6">
    <label class="form-control-label" for="ville_id">Sélectionnez la ville</label>
        @if(isset($enseignement))
            {!! Form::select('ville_id', $villes->pluck('nom', 'id'), $enseignement->ville->id, ['class' => 'form-control', 'id' => 'ville_id']) !!}
        @else
            <select id="ville_id" class="form-control" name="ville_id">
                @foreach($villes as $ville)
                    <option value="{{$ville->id}}">{{$ville->nom}}</option>
                @endforeach
            </select>
        @endif
</div>

<div class="col-sm-2 form-group">
    {!! Form::label('progression', 'Progression:') !!}
    {!! Form::checkbox('progression', 1, isset($enseignement) ? $enseignement->progression : null, ['class' => 'checkbox', auth()->user()->can('update enseignements')? '' : 'disabled']) !!}
</div>

<div class="col-sm-2 form-group">
    {!! Form::label('communication', 'F.Comm.') !!}
    {!! Form::checkbox('communication', 1, isset($enseignement) ? $enseignement->communication : null, ['class' => 'checkbox', auth()->user()->can('update enseignements')? '' : 'disabled']) !!}
</div>

<div class="col-sm-2 form-group">
    {!! Form::label('cc', 'Contrôle Continu') !!}
    {!! Form::checkbox('cc', 1, isset($enseignement) ? $enseignement->cc : null, ['class' => 'checkbox', auth()->user()->can('update enseignements')? '' : 'disabled']) !!}
</div>

<!-- <div class="form-group col-sm-6">
    @if(isset($enseignement))
        {!! Form::label('enseignement_type', 'Sélectionnez le type d\'enseignement :') !!}
        {!! Form::select('enseignement_type', array( 
                'RAS'=>'RAS',
                'En présentiel' => 'En présentiel', 
                'En ligne' => 'En ligne'
            ), $enseignement->enseignement_type, ['class' => 'form-control']
        )!!}
    @else
        <label class="form-control-label" for="enseignement_type">Sélectionnez le type d'enseignement :</label>
        <select id="enseignement_type" class="form-control" name="enseignement_type">
            <option value="En présentiel">En présentiel</option>
            <option value="En ligne">En ligne</option>
        </select>
    @endif
</div> -->

<div class="form-group">
    {{ Form::hidden('specialite_id', $specialite, ['class' => 'form-control']) }}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('enseignements.index') !!}" class="btn btn-default">Cancel</a>
</div>

