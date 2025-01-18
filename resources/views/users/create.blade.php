@extends('layouts.app')
@section('title')
    Create User
@endsection
@section('content')
    <div class="container mb-3">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Create User</h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
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
                            @foreach($designations as $designation)
                                <option value="{{$designation->code??''}}">{{$designation->name??''}}</option>
                            @endforeach
                        </select>
                        @error('designation_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">Select Role</option>
                            @foreach($user_roles as $user_role)
                                <option value="{{$user_role->code??''}}">{{$user_role->name??''}}</option>
                            @endforeach
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
