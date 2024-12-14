<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(10);
        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'department_id' => 'required|numeric|exists:departments,id',
            'member_id' => 'required|numeric|exists:members,id',
            'name' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
        ], [
            'department_id.required' => 'The department field is required.',
            'member_id.required' => 'The project manegar field is required.',
        ]);

        if (!$validator->fails()) {
            $project = Project::create([
                'department_id' => $request->input('department_id'),
                'member_id' => $request->input('member_id'),
                'name' => $request->input('name'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'description' => $request->input('description'),
                'admin_id' => $request->user()->id,
            ]);
            return response()->json([
                'status' => $project ? true : false,
                'message' => $project ? 'Project Created Successfully' : 'Project Created Failed!',
            ], $project ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(Project $project)
    {
        return response()->json([
            'status' => true,
            'data' => new ProjectResource($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validator = validator($request->all(), [
            'department_id' => 'required|numeric|exists:departments,id',
            'member_id' => 'required|numeric|exists:members,id',
            'name' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
        ], [
            'department_id.required' => 'The department field is required.',
            'member_id.required' => 'The project manegar field is required.',
        ]);

        if (!$validator->fails()) {
            $updated = $project->update($request->all());
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Project Updated Successfully' : 'Project Updated Failed!',
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
    public function destroy(Project $project)
    {
        $deleted = $project->delete();
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Project Deleted Successfully' : 'project Deleted Failed!',
        ], $deleted ?  Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function change_status(Request $request, Project $project)
    {
        $this->authorize('Change-Status-Project', $request->user());
        $validator = validator($request->all(), [
            'status' => 'required|string|in:pending,processing,completed,cancled'
        ]);

        if (!$validator->fails()) {
            $project->status = $request->input('status');
            $updated = $project->save();
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Status Updated Successfully' : 'Status Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_OK);
        }
    }
}