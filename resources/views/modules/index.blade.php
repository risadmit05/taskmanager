@extends('layouts.app')

@section('title', 'Modules')

@section('content')
    <!-- DataTables and Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center bg-light mb-4 shadow-sm p-3 rounded">
            <h2 class="text-primary">Modules</h2>
            <a href="{{ route('modules.create') }}" class="btn btn-primary">Add Modules</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <table id="data-table" class="table table-bordered table-striped shadow-sm">
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Project</th>
                        <th>Parent</th>
                        <th>Is Parent</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Data loaded via DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 25,
                ajax: '{{ route('modules.index') }}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'project.name', name: 'project.name', default: ''},
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'is_parent', name: 'is_parent'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        className: 'btn btn-sm btn-secondary',
                        text: 'Copy'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'btn btn-sm btn-secondary',
                        text: 'CSV'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-sm btn-secondary',
                        text: 'Excel'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-secondary',
                        text: 'Print'
                    }
                ],
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    },
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                },
                responsive: true,
                order: [[1, 'asc']]
            });
        });
    </script>
@endsection
