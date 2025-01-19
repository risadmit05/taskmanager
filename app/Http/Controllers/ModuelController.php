<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ModuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $users = User::get();
//        $dataGrid = Module::with('project:id,name','parent:id,name')->get();
//        dd($dataGrid);
        if ($request->ajax()) {
            $dataGrid = Module::with('project:id,name')->get();
            return DataTables::of($dataGrid)
                ->addIndexColumn()
                ->addColumn('parent_id', function ($row) {
                    return $row->parent ? $row->parent->name : ''; // Handle null parent
                })
                ->editColumn('is_parent', function ($dataGrid) {
                    if ($dataGrid->is_parent == '1')
                        return 'Yes';
                    if ($dataGrid->is_parent == '0')
                        return 'No';
                    return 'No';
                })
                ->editColumn('status', function ($dataGrid) {
                    if ($dataGrid->status == '1')
                        return 'Active';
                    if ($dataGrid->status == '0')
                        return 'Inactive';
                    return 'Cancel';
                })
                ->make(true);
        }
        return view('modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::get();
        $modules = Module::where('is_parent',1)->get(['id','name']);
        $sub_modules = Module::where('is_parent',0)->get(['id','name']);
        return view('modules.create',compact('projects','modules','sub_modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer|exists:projects,id',
            'module_id' => 'nullable|integer|exists:modules,id',
            'sub_module_id' => 'nullable|integer|exists:modules,id',
            'name' => 'required|string|max:100',
        ], [
            'project_id.required' => 'The project is required.',
            'project_id.integer' => 'The project must be an integer.',
            'project_id.exists' => 'The selected project does not exist.',
            'module_id.integer' => 'The module must be an integer.',
            'module_id.exists' => 'The selected module does not exist.',
            'sub_module_id.integer' => 'The sub-module must be an integer.',
            'sub_module_id.exists' => 'The selected sub-module does not exist.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name cannot exceed 100 characters.',
        ]);
        if ($validator->fails()) {
            return redirect()->route('modules.create')->with('error', 'Module not created.');
        }
        $parent_id = $request->sub_module_id ?? $request->module_id;
        $is_parent = $request->module_id === null && $request->sub_module_id === null ? 1 : 0;

        $user = new Module();
        $user->project_id = $request->project_id;
        $user->parent_id = $parent_id;
        $user->is_parent = $is_parent;
        $user->name = $request->name;
        $user->save();

        return redirect()->route('modules.index')->with('success', 'Module created successfully.');
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

    public function findModuleById($id)
    {
        $data = Module::where('is_parent', 1)->where('project_id',$id)->get(['id','name']);
        return response()->json($data);
    }
    public function findSubModuleById($id)
    {
        $data = Module::where('is_parent', 0)->where('parent_id',$id)->get(['id','name']);
        return response()->json($data);
    }
}
