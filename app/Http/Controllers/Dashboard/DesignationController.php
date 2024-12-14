<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class DesignationController extends BaseController
{

    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Designation::class, 'designation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('department')->withCount('members')->get();
        return view('dashboard.designations.index', ['designations' => $designations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('status', '=', true)->get(['id', 'name']);
        return view('dashboard.designations.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $storeDesignationRequest)
    {
        $storeDesignationRequest->validated();

        Designation::create($storeDesignationRequest->all());

        return redirect()->back()->with('message', 'Designation Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        return response()->json([
            'name' => $designation->name,
            'department' => $designation->department->name,
            'description' => $designation->description,
            'members_count' => $designation->members->count(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        $departments = Department::where('status', '=', true)->get(['id', 'name']);
        return view('dashboard.designations.edit', ['designation' => $designation, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesignationRequest $updateDesignationRequest, Designation $designation)
    {
        $updateDesignationRequest->validated();

        $designation->update($updateDesignationRequest->all());

        return redirect()->route('dashboard.designations.index')->with('message', 'Designation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $countsMembers = $designation->members->count();
        if ($countsMembers < 1) {
            $designation->delete();
            return redirect()->back()->with('message', 'Designation Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Designation Deleted Failed!');
        }
    }

    public function designationFilterCreate($id)
    {
        $designation = Designation::where('department_id', '=', $id)->get();
        return response()->json($designation);
    }

    public function designationFilterEdit($memberId, $id)
    {
        $designation = Designation::where('department_id', '=', $id)->get();
        return response()->json($designation);
    }
}
