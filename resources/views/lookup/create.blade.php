@extends('layouts.app')
@section('title')
    Create User
@endsection
@section('content')
    <div class="container mb-3">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Create Lookup</h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('lookups.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="designation_id" class="form-label">Designation</label>
                        <select name="designation_id" id="designation_id" class="form-select" required>
                            <option value="">Select Designation</option>
                            <option value="1">Designation 1</option>
                            <option value="2">Designation 2</option>
                            <option value="3">Designation 3</option>
                            <option value="4">Designation 4</option>
{{--                            @foreach($designations as $designation)--}}
{{--                                <option value="{{ $designation->id }}">{{ $designation->name }}</option>--}}
{{--                            @endforeach--}}
                        </select>
                        @error('designation_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="1">Role 1</option>
                            <option value="2">Role 2</option>
                            <option value="3">Role 3</option>
{{--                            @foreach($roles as $role)--}}
{{--                                <option value="{{ $role->id }}">{{ $role->name }}</option>--}}
{{--                            @endforeach--}}
                        </select>
                        @error('role_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
