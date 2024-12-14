<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignationResource;
use App\Models\Designation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Designation::class, 'designation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::orderBy('created_at', 'desc')->paginate(10);
        return DesignationResource::collection($designations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:designations',
            'description' => 'required|string',
            'department_id' => 'required|nullable|exists:departments,id',
        ]);

        if (!$validator->fails()) {
            $designation = Designation::create($request->all());
            return response()->json([
                'status' => $designation ? true : false,
                'message' => $designation ? 'Designation Created Successfully' : 'Designation Created Failed!',
            ], $designation ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(Designation $designation)
    {
        return response()->json([
            'status' => true,
            'data' => new DesignationResource($designation),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {

        $validator = validator($request->all(), [
            'name' => 'required|string|unique:designations,name,' . $designation->id,
            'description' => 'required|string',
            'department_id' => 'required|nullable|exists:departments,id',
        ]);

        if (!$validator->fails()) {
            $updated = $designation->update($request->all());

            return response()->json([
                'status' => $updated ? true : false,
                'message' =>  $updated ? 'Designation Updated Successfully' : 'Designation Updated Failed!',
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
    public function destroy(Designation $designation)
    {
        if ($designation->members->count() < 1) {
            $deleted = $designation->delete();
            return response()->json([
                'status' => $deleted ? true : false,
                'message' => $deleted ? 'Designation Deleted Successfully' : 'Designation Deleted Failed!',
            ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Designation Can Not Be Deleted!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}