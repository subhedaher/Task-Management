<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Member::class, 'member');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::orderBy('created_at', 'desc')->paginate(10);
        return MemberResource::collection($members);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:members',
            'phone' => 'required|string|unique:members',
            'address' => 'required|string',
            'password' => ['required', 'string', Password::min(8)->uncompromised()->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            'designation_id' => 'required|numeric|exists:designations,id',
            'image' => 'nullable|image|mimes:jpg,png',
        ], [
            'role_id.required' => 'The role field is required.',
            'designation_id.required' => 'The designation field is required.',
        ]);

        $imageName = null;

        if (!$validator->fails()) {
            $member = new Member();
            $member->name = $request->input('name');
            $member->email = $request->input('email');
            $member->phone = $request->input('phone');
            $member->address = $request->input('address');
            $member->password = Hash::make($request->input('password'));
            $member->designation_id = $request->input('designation_id');
            $member->admin_id = $request->user()->id;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs(path: 'members', name: $imageName);
                $member->image = 'members/' . $imageName;
            }
            $saved = $member->save();
            if ($saved) {
                $member->assignRole(Role::findById($request->input('role_id'), 'api-member'));
            }

            return response()->json([
                'status' => $saved ? true : false,
                'message' => $saved ? 'Member Created Successfully' : 'Member Created Failed!',
            ], $saved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(Member $member)
    {
        return response()->json([
            'status' => true,
            'data' => new MemberResource($member),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required|string|unique:members,phone,' . $member->id,
            'address' => 'required|string',
            'designation_id' => 'required|numeric|exists:designations,id',
            'image' => 'nullable|image|mimes:jpg,png',
        ], [
            'role_id.required' => 'The role field is required.',
            'designation_id.required' => 'The designation field is required.',
        ]);
        if (!$validator->fails()) {
            if ($request->hasFile('image')) {
                if ($member->image) {
                    Storage::delete($member->image);
                }
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs(path: 'members', name: $imageName);
                $data['image'] = 'members/' . $imageName;
            }

            if ($request->input('email') !== $member->email) {
                $member->email_verified_at = null;
                $member->save();
            }
            $updated = $member->update($request->all());
            if ($updated) {
                $member->syncRoles(Role::findById($request->input('role_id'), 'api-member'));
            }
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Member Updated Successfully' : 'Member Updated Failed!',
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
    public function destroy(Member $member)
    {
        $image = $member->image;
        $deleted = $member->delete();
        if ($deleted && $image) {
            Storage::delete($image);
        }
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Member Deleted Successfully' : 'Member Deleted Failed!',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
