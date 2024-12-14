<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class DepartmentController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::withCount('designations')->get();
        return view('dashboard.departments.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $storeDepartmentRequest)
    {
        $storeDepartmentRequest->validated();

        Department::create($storeDepartmentRequest->all());

        return redirect()->back()->with('message', 'Department Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json([
            'name' => $department->name,
            'description' => $department->description,
            'designations_count' => $department->designations->count(),
            'active' => $department->statusActive
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('dashboard.departments.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $updateDepartmentRequest, Department $department)
    {
        $updateDepartmentRequest->validated();

        $updateDepartmentRequest['status'] = $updateDepartmentRequest->input('status') === 'on';

        $department->update($updateDepartmentRequest->all());

        return redirect()->route('dashboard.departments.index')->with('message', 'Department Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $countsDesignations = $department->designations->count();
        $countsProjects = $department->projects->count();
        if ($countsDesignations < 1 &&  $countsProjects < 1) {
            $department->delete();
            return redirect()->back()->with('message', 'Department Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Department Deleted Failed!');
        }
    }
}
