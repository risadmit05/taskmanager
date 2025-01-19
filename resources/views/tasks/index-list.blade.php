@extends('layouts.app')
@section('title')
    Projects
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center bg-white mb-4 shadow-sm p-3 rounded">
            <h2>Tasks</h2>
{{--            <a href="{{ route('projects.create') }}" class="btn btn-primary">Add Project</a>--}}
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center bg-white mb-4 shadow-sm p-3 rounded">

        </div>
    </div>
@endsection
