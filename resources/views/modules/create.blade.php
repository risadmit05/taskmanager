@extends('layouts.app')
@section('title')
    Create Modules
@endsection
@section('content')
    <div class="container mb-3">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Create Modules</h2>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('modules.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project <span style="color:red;">*</span></label>
                        <select name="project_id" id="project_id" class="form-select" required>
                            <option value="">Select Project</option>
                            @if(isset($projects))
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('project_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="module_id" class="form-label">Module</label>
                        <select name="module_id" id="module_id" class="form-select" >

                        </select>
                        @error('module_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sub_module_id" class="form-label">Sub Module</label>
                        <select name="sub_module_id" id="sub_module_id" class="form-select" >
                        </select>
                        @error('sub_module_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span style="color:red;">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Modules</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer_js')
    <script>
        $(document).ready(function () {
            $('#project_id').on('change', function () {
                var project_id = $(this).val();
                // alert(divition_id);
                if (project_id) {
                    $.ajax({
                        url: '{{ url("/ajaxSearchGetModuleById") }}' + '/' + project_id,
                        type: 'GET',
                        success: function (data) {
                            $('#module_id').empty();
                            if (data && Object.keys(data).length > 0) {
                                $('#module_id').append('<option value="">Select Module</option>');
                                $.each(data, function (key, value) {
                                    $('#module_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                $('#module_id').append('<option value=""> No Data Available </option>');
                            }
                            // $("#permanent_district_id").trigger("change");
                            $("#sub_module_id").html("");
                        }
                    });
                }
            });

            $('#module_id').on('change', function () {
                var module_id = $(this).val();
                // alert(divition_id);
                if (module_id) {
                    $.ajax({
                        url: '{{ url("/ajaxSearchGetSubModuleById") }}' + '/' + module_id,
                        type: 'GET',
                        success: function (data) {
                            $('#sub_module_id').empty();
                            if (data && Object.keys(data).length > 0) {
                                $('#sub_module_id').append('<option value="">Select Sub Module</option>');
                                $.each(data, function (key, value) {
                                    $('#sub_module_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                $('#sub_module_id').append('<option value=""> No Data Available </option>');
                            }
                            // $("#permanent_district_id").trigger("change");
                            $("#sub_module_id").trigger("change");
                        }
                    });
                }
            });
        });
    </script>
@endsection
