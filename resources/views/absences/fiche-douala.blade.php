@extends('layouts.app')

@section('content')
	<section class="content-header">
        <h1 class="pull-left">Liste des Ecues Douala</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive">
                	<thead>
				        <tr>
				        	<th class="text-center">#</th>
				            <th>Title</th>
				            <th colspan="2">Afficher</th>
				        </tr>
    				</thead>
    				<?php $no=1; ?>
    				<tbody>
    					@foreach($ens as $en)
    						<tr>
    							<td class="text-center">{{$no++}}</td>
    							<td>{{$en->ecue->title}}</td>
								<td>
									<a href="{!! route('absences.fiche-ecue-douala', [$semestre, $specialite, $en->id]) !!}" class='btn btn-default btn-xs'>Fiche des présences Douala</a>
								</td>
								
							</tr>
						@endforeach
    				</tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
        	        	
        </div>
    </div>
@endsection

