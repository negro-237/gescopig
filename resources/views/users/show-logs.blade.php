<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>Gestion Scolaire de PIGIER Cameroun</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	    <!-- Bootstrap 3.3.7 -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	    <!-- Font Awesome -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	    <!-- Ionicons -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

	    <!-- Theme style -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css">

	    <!-- iCheck -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

	    <!-- Ionicons -->
	    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	    <link rel="../src/stylesheet" href="bootstrap-table-filter.css">
	    <meta name="csrf-token">

	</head>
	<body>
		<div class="container-fluid">
			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-12">
					<h3>Historique de navigation de : {{$user->name}}</h3>
	        		<div class="table-responsive">
	        			<table class="table table-bordered table-striped">
	        				<thead>
		        				<tr class="text-center">
		                            <th>User ID</th>
		                            <th>Revisionable_Type</th>
		                            <th>Revisionable_Id</th>
		                            <th>Key</th>
		                            <th>Ancienne valeur</th>
		                            <th>Nouvelle valeur</th>
		                            <th>Date de création</th>
		                            <th>Date de modification</th>
		                        </tr>
	        				</thead>
	        				<tbody>
	        					@foreach ($logs as $log)
	                                <tr>
		                                <td>{{ $log->user_id }}</td>
		                                <td>{{ $log->revisionable_type }}</td>
		                                <td>{{ $log->revisionable_id }}</td>
		                                <td>{{ $log->key }}</td>
		                                <td>{{ $log->old_value }}</td>
		                                <td>{{ $log->new_value }}</td>
		                                <td>{{ $log->created_at }}</td>
		                                <td>{{ $log->updated_at }}</td>
	                               	</tr>
	                            @endforeach
	        				</tbody>
	        			</table>
	        		</div>
	        	</div>
			</div>
		</div>
	</body>
</html>