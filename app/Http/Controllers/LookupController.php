<?php

namespace App\Http\Controllers;

use App\Models\Lookup;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class LookupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataGrid = Lookup::get();
            return DataTables::of($dataGrid)
                ->addIndexColumn()
                ->make(true);
        }
        return view('lookup.index');
    }

      /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:lookups|max:50',
            'type' => 'required|max:50',
            'name' => 'required|max:100',
        ]);
        $type = $request->type;

        // Check if the type is not already lowercase and contains spaces
        if ($type !== strtolower(str_replace(' ', '_', $type))) {
            $type = strtolower(str_replace(' ', '_', $type));
        }
        Lookup::create([
            'code' => $request->code,
            'type' => $type,
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Lookup created successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lookup = Lookup::findOrFail($id);
        return response()->json($lookup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:50|unique:lookups,code,' . $id,
            'type' => 'required|max:50',
            'name' => 'required|max:100',
        ]);

        $lookup = Lookup::findOrFail($id);
        $lookup->update([
            'code' => $request->code,
            'type' => $request->type,
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Lookup updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lookup = Lookup::findOrFail($id);
        $lookup->delete();

        return response()->json(['success' => 'Lookup deleted successfully.']);
    }
    public function getTypes()
    {
        $types = Lookup::select('id', 'type')->distinct()->get();
        return response()->json($types);
    }
}