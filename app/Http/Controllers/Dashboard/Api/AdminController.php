<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(10);
        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:admins',
            'phone' => 'required|string|unique:admins',
            'address' => 'required|string',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->uncompromised()
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
            'image' => 'nullable|image|mimes:jpg,png',
        ], [
            'role_id.required' => 'The role field is required.',
        ]);
        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->phone = $request->input('phone');
            $admin->address = $request->input('address');
            $admin->password = Hash::make($request->input('password'));
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs(path: 'admins', name: $imageName);
                $admin->image = 'admins/' . $imageName;
            }
            $admin->save();
            if ($admin) {
                $admin->assignRole(Role::findById($request->input('role_id'), 'api-admin'));
            }
            return response()->json([
                'status' => $admin ? true : false,
                'message' => $admin ? 'Admin Created Successfully' : 'Admin Created Failed!',
            ], $admin ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return response()->json([
            'status' => true,
            'data' => new AdminResource($admin),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'required|string|unique:admins,phone,' . $admin->id,
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png',
        ], [
            'role_id.required' => 'The role field is required.',
        ]);

        if (!$validator->fails()) {
            if ($request->hasFile('image')) {
                if ($admin->image) {
                    Storage::delete($admin->image);
                }
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs(path: 'admins', name: $imageName);
                $request['image'] = 'admins/' . $imageName;
            }
            if ($request->input('email') !== $admin->email) {
                $admin->email_verified_at = null;
                $admin->save();
            }
            $updated = $admin->update($request->all());
            if ($updated) {
                $admin->syncRoles(Role::findById($request->input('role_id'), 'api-admin'));
            }

            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Admin Updated Successfully' : 'Admin Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
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
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Admin Deleted Successfully' : 'Admin Deleted Failed!',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}