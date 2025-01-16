<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $users = User::get();
        if ($request->ajax()) {
            $dataGrid = User::get();
            return DataTables::of($dataGrid)
                ->addIndexColumn()
                ->make(true);
        }
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Name is required, a string, and should not exceed 255 characters.
            'email' => 'required|email|max:255|unique:users,email', // Email is required, should be a valid email, max length 255, and unique in users table.
            'password' => 'required|string|min:8', // Password is required, should be a string, minimum length of 8 characters, and must match the confirmation field.
//            'designation_id' => 'required|exists:designations,id', // Designation ID is required and must exist in the 'designations' table.
//            'role_id' => 'required|exists:roles,id', // Role ID is required and must exist in the 'roles' table.
            'designation_id' => 'required', // Designation ID is required and must exist in the 'designations' table.
            'role_id' => 'required', // Role ID is required and must exist in the 'roles' table.
        ]);
        if ($validator->fails()) {
            return redirect()->route('users.index')->with('error', 'User created successfully.');
        }
        // Create the user with validated data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash the password before storing
        $user->designation_id = $request->designation_id;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
