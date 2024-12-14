<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Member;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class MemberController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Member::class, 'member');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('dashboard.members.index', ['members' => $members]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', '=', 'member')->get(['id', 'name']);
        $departments = Department::where('status', '=', true)->get(['id', 'name']);
        return view('dashboard.members.create', ['roles' => $roles, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $storeMemberRequest)
    {
        $storeMemberRequest->validated();
        $member = new Member();
        $member->name = $storeMemberRequest->input('name');
        $member->email = $storeMemberRequest->input('email');
        $member->password = Hash::make($storeMemberRequest->input('password'));
        $member->phone = $storeMemberRequest->input('phone');
        $member->address = $storeMemberRequest->input('address');
        $member->designation_id = $storeMemberRequest->input('designation_id');
        $member->admin_id = user()->id;
        $saved = $member->save();
        if ($saved) {
            $role = Role::where('id', '=', $storeMemberRequest->input('role_id'))->where('guard_name', '=', 'member')->first();
            $member->assignRole($role->name);
        }
        return redirect()->back()->with('message', 'Member Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('dashboard.members.show', ['member' => $member]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $roles = Role::where('guard_name', '=', 'member')->get();
        $departments = Department::where('status', '=', true)->get(['id', 'name']);
        $designations = Designation::where('department_id', '=', $member->designation->department->id)->get(['id', 'name']);
        return view('dashboard.members.edit', ['member' => $member, 'roles' => $roles, 'departments' => $departments, 'designations' => $designations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $updateMemberRequest, Member $member)
    {
        $updateMemberRequest->validated();

        if ($member->email !== $updateMemberRequest->input('email')) {
            $member->email_verified_at = null;
        }

        $member->name = $updateMemberRequest->input('name');
        $member->email = $updateMemberRequest->input('email');
        $member->phone = $updateMemberRequest->input('phone');
        $member->address = $updateMemberRequest->input('address');
        $member->status = $updateMemberRequest->input('status') === 'on';
        $member->designation_id = $updateMemberRequest->input('designation_id');
        $updated = $member->save();
        if ($updated) {
            $role = Role::where('id', '=', $updateMemberRequest->input('role_id'))->where('guard_name', '=', 'member')->first();
            $member->syncRoles($role->name);
        }
        return redirect()->route('dashboard.members.index')->with('message', 'Member Updated Successfully');
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
        return redirect()->back()->with('message', 'Member Deleted Successfully');
    }

    public function projectManagerFilterCreate($id)
    {
        $designationsId = Designation::where('department_id', $id)->pluck('id');

        $members = Member::whereHas('roles', function ($q) {
            $q->where('name', 'Project manager');
        })->whereIn('designation_id', $designationsId)->get();

        return response()->json($members);
    }

    public function projectManagerFilterEdit($memberId, $id)
    {
        $designationsId = Designation::where('department_id', $id)->pluck('id');

        $members = Member::whereHas('roles', function ($q) {
            $q->where('name', 'Project manager');
        })->whereIn('designation_id', $designationsId)->get();

        return response()->json($members);
    }
}
