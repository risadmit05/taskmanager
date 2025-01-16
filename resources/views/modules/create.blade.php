@extends('layouts.app')
@section('title')
    Create Modules
@endsection
@section('content')
    <div class="container mb-3">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Create Modules</h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project</label>
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
                            <option value="">Select Module</option>
                            @if(isset($modules))
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('module_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sub_module_id" class="form-label">Sub Module</label>
                        <select name="sub_module_id" id="sub_module_id" class="form-select" >
                            <option value="">Select Sub Module</option>
                            @if(isset($sub_modules))
                                @foreach($sub_modules as $sub_module)
                                    <option value="{{ $sub_module->id }}">{{ $sub_module->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('sub_module_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Modules</button>
                </form>
            </div>
        </div>
    </div>
@endsection
