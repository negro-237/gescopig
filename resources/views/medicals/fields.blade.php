
<!-- Masse horaire total Field -->

<div class="form-group col-sm-12">
    {!! Form::label('symptoms', 'Signes/Symptomes:') !!}
    {!! Form::textarea('symptoms', isset($medical) ? $medical->symptoms : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('first_aid', 'Premier soins:') !!}
    {!! Form::textarea('first_aid', isset($medical) ? $medical->first_aid : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('advice', 'Avis infirmier:') !!}
    {!! Form::textarea('advice', isset($medical) ? $medical->advice : null, ['class' => 'form-control', auth()->user()->can('edit enseignements')? '' : 'disabled']) !!}
</div>

<div class="form-group">
    {{ Form::hidden('student_id', isset($medical) ? $medical->student->id : $student_id, ['class' => 'form-control']) }}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('medicals.index', [isset($medical) ? $medical->student->id : $student_id]) !!}" class="btn btn-default">Cancel</a>
</div>

