<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class RoleController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        $guards = ['admin' => 'Admin', 'superviser' => 'Superviser'];
        return view('dashboard.roles.index', ['roles' => $roles, 'guards' => $guards]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guards = ['admin' => 'Admin', 'member' => 'Member', 'api-admin' => 'Admin-Api', 'api-member' => 'Member-Api'];
        return view('dashboard.roles.create', ['guards' => $guards]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $storeRoleRequest)
    {
        $storeRoleRequest->validated();
        Role::create([
            'name' => $storeRoleRequest->input('name'),
            'guard_name' => $storeRoleRequest->input('guard_name')
        ]);

        return redirect()->back()->with('message', 'Role Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();
        
        $rolePermissions = $role->permissions;

        if (count($rolePermissions)) {
            foreach ($rolePermissions as $userPermissions) {
                foreach ($permissions as $permission) {
                    if ($permission->id === $userPermissions->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }

        return view('dashboard.roles.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function updateRolePermission(Request $request)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id'
        ]);

        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            $role = Role::findOrFail($request->input('role_id'));

            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission)
                : $role->givePermissionTo($permission);

            return response()->json([
                'status' => true,
                'message' => 'permission Updated Successfully'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function edit(Role $role)
    {
        $guards = ['admin' => 'Admin', 'member' => 'Member', 'api-admin' => 'Admin-Api', 'api-member' => 'Member-Api'];
        return view('dashboard.roles.edit', ['role' => $role, 'guards' => $guards]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $updateRoleRequest, Role $role)
    {
        $updateRoleRequest->validated();
        $role->guard_name = $updateRoleRequest->input('guard_name');
        $role->name = $updateRoleRequest->input('name');
        $role->save();
        return redirect()->route('dashboard.roles.index')->with('message', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('message', 'Role Deleted Successfully');
    }
}
