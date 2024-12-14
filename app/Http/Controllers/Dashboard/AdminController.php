<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class AdminController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        return view('dashboard.admins.index', ['admins' => $admins]);
    }

    public function create()
    {
        $roles = Role::where('guard_name', '=', 'admin')->get(['id', 'name']);
        return view('dashboard.admins.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $storeAdminRequest)
    {
        $storeAdminRequest->validated();
        $admin = new Admin();
        $admin->name = $storeAdminRequest->input('name');
        $admin->email = $storeAdminRequest->input('email');
        $admin->password = Hash::make($storeAdminRequest->input('password'));
        $admin->phone = $storeAdminRequest->input('phone');
        $admin->address = $storeAdminRequest->input('address');
        $saved = $admin->save();
        if ($saved) {
            $role = Role::where('id', '=', $storeAdminRequest->input('role_id'))->where('guard_name', '=', 'admin')->first();
            $admin->assignRole($role->name);
        }
        return redirect()->back()->with('message', 'Admin Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Admin $admin)
    {
        // 
    }

    public function edit(Request $request, Admin $admin)
    {
        $roles = Role::where('guard_name', '=', 'admin')->get();
        return view('dashboard.admins.edit', ['admin' => $admin, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $updateAdminRequest, Admin $admin)
    {
        $updateAdminRequest->validated();

        if ($admin->email !== $updateAdminRequest->input('email')) {
            $admin->email_verified_at = null;
        }

        $admin->name = $updateAdminRequest->input('name');
        $admin->email = $updateAdminRequest->input('email');
        $admin->phone = $updateAdminRequest->input('phone');
        $admin->address = $updateAdminRequest->input('address');
        $admin->status = $updateAdminRequest->input('status') === 'on';
        $updated = $admin->save();
        if ($updated) {
            $role = Role::where('id', '=', $updateAdminRequest->input('role_id'))->where('guard_name', '=', 'admin')->first();
            $admin->syncRoles($role->name);
        }
        return redirect()->route('dashboard.admins.index')->with('message', 'Admin Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $image = $admin->image;
        $deleted = $admin->delete();
        if ($deleted && $image) {
            Storage::delete($image);
        }
        return redirect()->back()->with('message', 'Admin Deleted Successfully');
    }
}
