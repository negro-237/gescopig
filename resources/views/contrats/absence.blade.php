@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="clearfix"></div>

            @include('flash::message')

            <div class="clearfix"></div>

            <div class="box box-primary">
                <div class="box-header">
                    <h1 class="clearfix">Historique des absences</h1>
                </div>
                <div class="box-body">
                    <table class="table table-responsive results" id="contrats-table">
                        <thead>
                            <tr>
                                <th>ECue</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absences as $item)
                            <tr>
                                <td>{{ $item->ecue->title }}</td>
                                <td>{{ $item->date->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection