<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('created_at', 'desc')->paginate(10);
        return DepartmentResource::collection($departments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:departments',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        if (!$validator->fails()) {
            $department = Department::create($request->all());
            return response()->json([
                'status' => $department ? true : false,
                'message' => $department ? 'Department Created Successfully' : 'Department Created Failed!',
            ], $department ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(Department $department)
    {
        return response()->json([
            'status' => true,
            'data' => new DepartmentResource($department),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:departments,name,' . $department->id,
            'description' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        if (!$validator->fails()) {
            $updated = $department->update($request->all());
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Department Updated Successfully' : 'Department Updated Failed!',
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
    public function destroy(Department $department)
    {
        if ($department->designations->count() < 1) {
            $deleted = $department->delete();
            return response()->json([
                'status' => $deleted ? true : false,
                'message' => $deleted ? 'Department Deleted Successfully' : 'Department Deleted Failed!',
            ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Department Can Not Be Deleted!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}