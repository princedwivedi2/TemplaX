<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin']);
    }

    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        dd('yiyi');
        $users = User::with('roles')->get();
        $roles = Role::pluck('name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Display a listing of admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function admins()
    {
        $admins = User::role('admin')->with('roles')->get();
        $roles = Role::pluck('name');

        return view('admin.users.admins', compact('admins', 'roles'));
    }

    /**
     * Get users data for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Request $request)
    {
        $users = User::with('roles')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Get admins data for AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAdmins(Request $request)
    {
        $admins = User::role('admin')->with('roles')->get();

        return response()->json([
            'success' => true,
            'data' => $admins
        ]);
    }

    /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Determine if this is a Super Admin creation (no role required)
        $isSuperAdmin = $request->has('is_super_admin') && $request->is_super_admin === 'true';

        // Build validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'organization' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];

        // Only require role for non-Super Admin users
        if (!$isSuperAdmin) {
            $rules['role'] = ['required', 'string', Rule::in(['admin', 'user'])];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'organization' => $request->organization,
            'password' => Hash::make($request->password),
        ]);

        // Assign appropriate role
        if ($isSuperAdmin) {
            $user->assignRole('super-admin');
        } else {
            $user->assignRole($request->role);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'data' => $user->load('roles')
        ]);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Determine if this is a Super Admin update
        $isSuperAdmin = $request->has('is_super_admin') && $request->is_super_admin === 'true';
        $wasSuperAdmin = $user->hasRole('super-admin');

        // Build validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'organization' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ];

        // Only require role for non-Super Admin users
        if (!$isSuperAdmin) {
            $rules['role'] = ['required', 'string', Rule::in(['admin', 'user'])];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->organization = $request->organization;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Handle role changes
        if ($isSuperAdmin && !$wasSuperAdmin) {
            // Changing to Super Admin
            $user->syncRoles(['super-admin']);
        } else if (!$isSuperAdmin && $wasSuperAdmin) {
            // Changing from Super Admin to another role
            $user->syncRoles([$request->role]);
        } else if (!$isSuperAdmin && !$wasSuperAdmin && !$user->hasRole($request->role)) {
            // Regular role change
            $user->syncRoles([$request->role]);
        }
        // If user was and still is Super Admin, no role change needed

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'data' => $user->load('roles')
        ]);
    }

    /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if (auth()->id() == $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account!'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
