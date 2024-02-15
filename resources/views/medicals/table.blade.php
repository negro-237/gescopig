
<table cellpadding="0" cellspacing="0" class="table responsive table-stripped results tablesorter" id="medicals-table">
    <thead>
    <tr>
        <th>Signes/Symptomes</th>
        <th>Premier soins</th>
        <th>Avis de l'infirmier</th>
        <th>Annee scolaire</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    @foreach($medicals as $medical)
        <tr>
            <td>{!! $medical->symptoms !!}</td>
            <td>{!! $medical->first_aid !!}</td>
            <td>{!! $medical->advice !!}</td>
            <td>{!! $medical->academic->debut !!}/{!! $medical->academic->fin !!}</td>
            <td>{!! $medical->created_at->format('d-m-y') !!}</td>
            <td>
                {!! Form::open(['route' => ['medicals.destroy', $medical->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('medicals.edit', [$medical->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    <script src="http://localhost/pigier/public/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#medicals-table').DataTable({
                responsive: true,
                dom:'Blfrtip',
                buttons:[
                    'copy', 'excel', 'pdf'
                ],
                "columnDefs":[
                    {"orderable":false, "targets":5}
                ]
            });

            table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container() ))

        });
    </script>

@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
    <style>
        .results tr[visible='false'], .no-result{
            display: none;
        }
        .results tr[visible='true']{
            display: table-row;
        }
        .counter{
            padding: 8px;
            color: #acacac;
        }
    </style>
@endsection