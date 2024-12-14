<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:roles',
            'guard_name' => 'required|string|in:admin,member,api-admin,api-member',
        ]);
        if (!$validator->fails()) {
            $role = Role::create($request->all());
            return response()->json([
                'status' => $role ? true : false,
                'message' => $role ? 'Role Created Successfully' : 'Role Created Failed!',
            ], $role ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json([
            'status' => true,
            'data' => new RoleResource($role),
        ], Response::HTTP_OK);
    }

    public function updateRolePermission(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id'
        ], [
            'role_id.required' => 'The role field is required.',
            'permission_id.required' => 'The permission field is required.',
        ]);

        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            $role = Role::findOrFail($request->input('role_id'));

            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission)
                : $role->givePermissionTo($permission);

            return response()->json([
                'status' => true,
                'message' => 'Permission Updated Successfully'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'guard_name' => 'required|string|in:admin,member,api-admin,api-member',
        ]);
        if (!$validator->fails()) {
            $updated = $role->update($request->all());

            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Role Updated Successfully' : 'Role Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->users->count() < 1) {
            $deleted = $role->delete();
            return response()->json([
                'status' => $deleted ? true : false,
                'message' =>  $deleted ? 'Role Deleted Successfully' : 'Role Deleted Failed!',
            ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Role Can Not Be Deleted!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}