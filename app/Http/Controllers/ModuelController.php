<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $users = User::get();
//        if ($request->ajax()) {
//            $dataGrid = User::get();
//            return DataTables::of($dataGrid)
//                ->addIndexColumn()
//                ->make(true);
//        }
        return view('modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::get();
        return view('modules.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
