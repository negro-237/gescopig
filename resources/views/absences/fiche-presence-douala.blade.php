<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Scolaire de PIGIER Cameroun</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <style>            
            @media print { 
                .table td, .table th { 
                    border: 1px solid #000000 !important;
                } 
            }
        </style>

    </head>
    <body>  	
        <div class="content">
            <div class="clearfix"></div>
            <div class="box box-primary">
            	<div class="box-body">
            		<div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <img src="{{ url('images/logo_pigier.jpg') }}" style="width:250px; height:125px" alt="">
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                    	<div class="col-lg-12">
                    		<div class="row"  >
                                <div class="col-lg-12">
                                    <h3 style="text-align: center; text-decoration: underline;">FICHE DE SUIVI DES APPRENANTS PAR ECUE DOUALA</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 style="text-align: center; text-decoration: underline; margin-top: 20px">ANNEE ACADEMIQUE {{ $enseignement->academic_year->debut }} - {{ $enseignement->academic_year->fin }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        GRADE: {{ $enseignement->ecue->semestre->cycle->label }}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        NIVEAU: {{ $enseignement->ecue->semestre->cycle->niveau }}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        ECUE: {{$enseignement->ecue->title}}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">

                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        SPECIALITE: {{$enseignement->specialite->slug}}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">

                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        ENSEIGNANT: {{$enseignement->contratEnseignant->enseignant->name}}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">

                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                       
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        
                                    </small>
                                </div>
                            </div>
                    	</div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12" style="margin-top:10px">
                            <table class="table table-bordered" >
        						<thead class="thead-dark">
        							<tr style="height: 65px;">
        								<th class="text-center" style="vertical-align: middle;">N°</th>
                						<th class="text-center" style="vertical-align: middle;">NOM ET PRENOM</th>
                                        <th class="text-center" ></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
        							</tr>
        						</thead>
                                <?php $no=1; ?>
        						<tbody>
                                    @foreach($apprenants as $apprenant)
                                        @if($apprenant->contrats->count() != 0)
                                            @foreach($apprenant->contrats as $a)
                                                <tr>
                                                    <td class="text-center" style="vertical-align: middle;">{{$no++}}</td>
                                                    <td>{{ $apprenant->nom }} {{ $apprenant->prenom }}</td>
                                                    <td ></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                						@endif
                                    @endforeach
                                    <tr style="height: 65px;">
                                        <td></td>
                                        <td class="text-center" style="vertical-align: bottom;">Visa de l'enseignant</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
            					</tbody>
        					</table>        
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <p>NB: Cocher dans la case les absences du jour</p>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
        <!-- jQuery 3.1.1 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>