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
                                    <h3 style="text-align: center; text-decoration: underline;">FICHE DE NOTATION CONTRÔLE CONTINU</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        ANNEE ACADEMIQUE: {{ $enseignement->academic_year->debut }}-{{ $enseignement->academic_year->fin }}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        
                                    </small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        SEMESTRE: {{$enseignement->ecue->semestre->title}}
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
                                        GRADE: {{ $enseignement->ecue->semestre->cycle->label }}
                                    </small> 
                                    <small style="font-size:18px; font-weight: bold; text-transform: uppercase;">
                                        
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <small style="font-size: 18px; font-weight: bold;">
                                        SPECIALITE: {{$enseignement->specialite->slug}}
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
                    	</div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12" style="margin-top:30px">
                            <table class="table table-striped table-bordered" >
        						<thead class="thead-dark">
        							<tr>
        								<th class="text-center">N°</th>
                						<th class="text-center">NOM ET PRENOM</th>
                						<th class="text-center ">NOTE/20</th>
                                        <th class="text-center ">OBSERVATION</th>
        							</tr>
        						</thead>
                                <?php $no=1; ?>
        						<tbody>
                                    @foreach($apprenants as $apprenant)
                                        @if($apprenant->contrats->count() != 0)
                                            @foreach($apprenant->contrats as $a)
                        						<tr style="height: 35px">
                                                    <td class="text-center">{{$no++}}</td>
                                                    <td>{!! $apprenant->nom !!} {!! $apprenant->prenom !!}</td>
                                                    <td></td>
                                                    <td></td>
                        						</tr>
                                            @endforeach
                                        @endif
                                    @endforeach
            					</tbody>
        					</table>        
                        </div>
                    </div>
                    <div class="row" style="margin:10px">
                        <div class="col-lg-12">
                            <p>Nom et signature de l'enseignant</p>
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