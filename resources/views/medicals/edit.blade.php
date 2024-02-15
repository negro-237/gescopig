@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fiche Medicale
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($medical, ['route' => ['medicals.update', $medical->id], 'method' => 'patch']) !!}

                        @include('medicals.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection