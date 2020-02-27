@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Publishers</h1>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('publishers.create') }}">
                    Add Publisher
                </a>
            </div>
        </div>
        <div class="row">
            <section class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">City</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Zip</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">W9</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('plugins.Datatables', true)

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script> 
        console.log('Hi!'); 
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                console.log(start.format('MMMM D, YYYY') + " "+end.format('MMMM D, YYYY'));

                $('.data-table').DataTable().destroy();

                var table = $('.data-table').DataTable({
                    processing: true,
                    // serverSide: true,
                    ajax: {
                        url: "{{ route('publishers.index') }}",
                        data: { startDate: start.format('MMMM D, YYYY'), endDate: end.format('MMMM D, YYYY') }
                    },
                    columns: [
                        { data: 'publisher_name' },
                        { data: 'address' },
                        { data: 'city' },
                        { data: 'state' },
                        { data: 'zip' },
                        { data: 'phone' },
                        { data: 'w9' },
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    pageLength: 100
                });
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $(document).on('click', '.delete-publisher', function(){
                var id = $(this).attr('data-id');
                var token = $("meta[name='csrf_token']").attr("content");
                if(confirm("Are you sure you want to delete this publisher?")) {
                    $.ajax({
                        url: "publishers/"+id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                            "_method": 'DELETE'
                        },
                        success: function(json) {
                            $('.data-table').DataTable().ajax.reload();
                        }
                    });
                }
            });

        });
    </script>
@stop