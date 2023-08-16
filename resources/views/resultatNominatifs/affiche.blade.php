@extends('layouts.app')

@section('content')

    <section class="content-header">

    </section>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive table-bordered" id="resultat-table">
                    <thead>
                    <tr>
                        <th rowspan="3">Nom et prenom</th>
                        <th colspan="{{ $cycle->niveau * 4 }}" class="text-center">Semestres</th>
                        <th rowspan="3" class="text-center">Decision</th>
                    </tr>
                    <tr>
                        @if($contrats->first())
                            @if($cycle->niveau == 1)
                                <th colspan="2" class="text-center">{{ $cycle->semestres->first()->title }}</th>
                                <th colspan="2" class="text-center">{{ $cycle->semestres->last()->title }}</th>
                            @elseif($cycle->niveau >= 2)
                                @foreach($contrats->first()->apprenant->contrats as $contrat)
                                    @if($contrat->cycle->label == $cycle->label && $contrat->cycle->niveau <= $cycle->niveau)
                                        <th colspan="2" class="text-center">{{ $contrat->cycle->semestres->first()->title }}</th>
                                        <th colspan="2" class="text-center">{{ $contrat->cycle->semestres->last()->title }}</th>
                                    @endif
                                @endforeach
                            @endif
                        @else
                            {{ $contrats->first()->cycle }}
                        @endif

                    </tr>
                    <tr>
                        @if($contrats->first())
                            @if($cycle->niveau == 1)
                                <th>Credit</th>
                                <th>Validation</th>
                                <th>Credit</th>
                                <th>Validation</th>
                            @elseif($cycle->niveau >= 2)
                                @foreach($contrats->first()->apprenant->contrats as $contrat)
                                    @if($contrat->cycle->label == $cycle->label && $contrat->cycle->niveau <= $cycle->niveau)
                                        <th>Credit</th>
                                        <th>Validation</th>
                                        <th>Credit</th>
                                        <th>Validation</th>             
                                    @endif
                                @endforeach
                            @endif
                        @else
                            {{ $contrats->first()->cycle }}
                        @endif
                        
                    </tr>

                    </thead>

                    <tbody>
                    {{ Form::open(['route' => ['resultatNominatifs.store']]) }}
                    @foreach($contrats as $contrat)
                        @if($contrat->resultatNominatifs->first())
                            <tr>
                                
                                <td>{!! $contrat->apprenant->nom. ' ' .$contrat->apprenant->prenom !!}</td>
                                @if($cycle->niveau == 1)
                                    @foreach($contrat->semestre_infos as $semestreInfo)
                                        <td>{!! $semestreInfo->creditObt !!}</td>
                                        <td>{!! ($semestreInfo->mention != 'Non Validé') ? 'V' : 'NV' !!}</td>
                                    @endforeach
                                    @if(!$contrat->semestre_infos->first())
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                    
                                @elseif($cycle->niveau >= 2)
                                    @foreach($contrats->first()->apprenant->contrats as $c)
                                        @if($c->cycle->label == $cycle->label && $c->cycle->niveau <= $cycle->niveau)
                                            @foreach($c->semestre_infos as $semestreInfo)
                                                <td>{!! $semestreInfo->creditObt !!}</td>
                                                <td>{!! ($semestreInfo->mention != 'Non Validé') ? 'V' : 'NV' !!}</td>
                                            @endforeach
                                            @if(!$c->semestre_infos->first())
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                <td>
                                    {!! $contrat->resultatNominatifs->first()->decision !!}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="form-group col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}
                    <a href="{!! route('resultatNominatifs.search', 1) !!}" class="btn btn-default pull-right">Cancel</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>

@endsection