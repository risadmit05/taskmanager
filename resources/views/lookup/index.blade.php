@extends('layouts.app')

@section('title', 'Lookup')

@section('content')
<!-- DataTables and Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container">
    <div class="d-flex justify-content-between align-items-center bg-light mb-4 shadow-sm p-3 rounded">
        <h2 class="text-primary">Lookup</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#lookupModal" id="createNewLookupBtn">Add Lookup</button>
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
                        <th>Code</th>
                        <th>Type</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data loaded via DataTables -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add/Edit Modal -->
    <!-- Modal -->
    <div class="modal fade" id="lookupModal" tabindex="-1" aria-labelledby="lookupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lookupModalLabel">Add / Edit Lookup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="lookupForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="lookup-id"> <!-- Hidden field for ID when editing -->

                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" name="code" id="code" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type-option" class="form-label">Type</label>
                            <select id="type-option" class="form-select" required>
                                <option value="existing">Select Existing Type</option>
                                <option value="new">Add New Type</option>
                            </select>
                        </div>

                        <!-- Existing Type Selector -->
                        <div class="mb-3 existing-type">
                            <label for="existing-type" class="form-label">Existing Type</label>
                            <select name="type" id="existing-type" class="form-select select2" style="width: 100%;" disabled>
                                <!-- Options will be populated dynamically via AJAX -->
                            </select>
                        </div>

                        <!-- New Type Input -->
                        <div class="mb-3 new-type d-none">
                            <label for="new-type" class="form-label">New Type</label>
                            <input type="text" name="new_type" id="new-type" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="modal-action-btn">Save Lookup</button>
                    </div>
                </form>
            </div>
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
            ajax: '{{ route('lookups.index') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'name',
                    name: 'name'
                },
            ],
            dom: 'Bfrtip',
            buttons: [{
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
            order: [
                [1, 'asc']
            ]
        });

    });
</script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for existing type dropdown
        // $('.select2').select2({
        //     placeholder: "Select a type",
        //     allowClear: true,
        //     dropdownAutoWidth: true,
        // });

        // Toggle between existing type and new type input
        $('#type-option').on('change', function() {
            let selectedOption = $(this).val();
            if (selectedOption === 'new') {
                $('.new-type').removeClass('d-none');
                $('.existing-type').addClass('d-none');
                $('#existing-type').val(null).trigger('change'); // Reset existing type dropdown
                $('#existing-type').prop('disabled', true);
            } else {
                $('.new-type').addClass('d-none');
                $('.existing-type').removeClass('d-none');
                $('#new-type').val(''); // Reset new type input
                $('#existing-type').prop('disabled', false);
            }
        });

        // Open modal for creating a new lookup (Reset form)
        $('#createNewLookupBtn').on('click', function() {
            $('#lookupForm')[0].reset(); // Reset form fields
            $('#lookup-id').val(''); // Clear hidden ID field
            $('#type-option').val('existing'); // Set default type option to "existing"
            $('.new-type').addClass('d-none'); // Hide "New Type" field
            $('.existing-type').removeClass('d-none'); // Show "Existing Type" field
            $('#modal-action-btn').text('Save Lookup'); // Change button text to "Save"
             // Fetch types via AJAX and populate the dropdown
             // Fetch grouped types via AJAX
              // Add the default option first
 $('#existing-type').append('<option value="" disabled selected>Select an Existing Type</option>');

        $.ajax({
            url: '{{ route('get.types') }}',
            method: 'GET',
            success: function(data) {
                console.log(data); // Log the data to inspect

                // Loop through each group (type) and add them to the dropdown
                $.each(data, function(index, item) {
                    $('#existing-type').append('<option value="' + item.type + '">' + item.type + '</option>');
                });
                // Reinitialize Select2 after adding options
                // $('#existing-type').select2();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching types:', error);
            }
        });
        $('#existing-type').prop('disabled', false);
            $('#lookupModal').modal('show'); // Open modal
        });

        // Open modal for editing a lookup
        $('body').on('click', '.edit-lookup-btn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '/lookups/' + id,
                method: 'GET',
                success: function(response) {
                    $('#lookup-id').val(response.id); // Set the hidden ID field
                    $('#code').val(response.code);
                    $('#name').val(response.name);
                    $('#type-option').val('existing').trigger('change'); // Select "Existing Type"
                    $('#existing-type').val(response.type).trigger('change'); // Set the selected existing type
                    $('#modal-action-btn').text('Update Lookup'); // Change button text to "Update"
                   
                    $('#lookupModal').modal('show'); // Open modal
                }
            });
        });

        // Handle form submission (example for AJAX)
        $('#lookupForm').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                code: $('#code').val(),
                name: $('#name').val(),
                type: $('#type-option').val() === 'new' ? $('#new-type').val() : $('#existing-type').val(),
                _token: $('input[name="_token"]').val(),
            };

            let lookupId = $('#lookup-id').val();
            let url = lookupId ? '/lookups/update/' + lookupId : "{{ route('lookups.store') }}";

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                success: function(response) {
                    alert(response.success);
                    $('#lookupModal').modal('hide');
                    $('#lookupForm')[0].reset();
                    $('#users-table').DataTable().ajax.reload(); // Reload the DataTable
                },
                error: function(xhr) {
                    alert('Something went wrong!');
                }
            });
        });
    });
</script>

@endsection