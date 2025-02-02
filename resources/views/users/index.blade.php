@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <!-- DataTables and Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center bg-light mb-4 shadow-sm p-3 rounded">
            <h2 class="text-primary">Users</h2>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add Users</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <table id="users-table" class="table table-bordered table-striped shadow-sm">
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Role</th>
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
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 25,
                ajax: '{{ route('users.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'designation_id', name: 'designation_id' },
                    { data: 'role_id', name: 'role_id' },
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
