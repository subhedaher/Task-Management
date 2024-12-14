<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AttachmentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Attachment::class, 'attachment');
    }

    /**
     * Display a listing of the resource.
     */
    public function task(Request $request, Task $task)
    {
        $this->authorize('Read-Attachments', $request->user());
        $attachments = $task->attachments;
        return AttachmentResource::collection($attachments);
    }

    /**
     * Display a listing of the resource.
     */
    public function project(Request $request, Project $project)
    {
        $this->authorize('Read-Attachments', $request->user());
        $attachments = $project->attachments;
        return AttachmentResource::collection($attachments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'file_name' => 'required|string',
            'file' => 'required|array',
            'file.*' => 'required|file|mimes:jpg,png,jpeg,pdf,docx|max:2048',
            'task_id' => 'nullable|numeric|exists:tasks,id',
            'project_id' => 'nullable|numeric|exists:projects,id',
        ]);

        $validator->after(function ($validator) use ($request) {
            $taskId = $request->input('task_id');
            $projectId = $request->input('project_id');

            if (empty($taskId) && empty($projectId)) {
                $validator->errors()->add('task or project', 'Either task or project must be provided.');
            }

            if (!empty($taskId) && !empty($projectId)) {
                $validator->errors()->add('task or project', 'Only one of task or project should be provided.');
            }
        });

        if (!$validator->fails()) {
            $attachments = [];
            foreach ($request->file('file') as $file) {
                $fileType = $file->getClientOriginalExtension();
                $uploadedBy = $request->user()->id;
                $attachment = new Attachment([
                    'file_name' => $request->input('file_name'),
                    'file_type' => $fileType,
                    'uploaded_by' => $uploadedBy,
                ]);

                if ($request->has('task_id')) {
                    $task = Task::findOrFail($request->input('task_id'));
                    $attachment->file_path = $file->store('attachments/tasks', 'public');
                    $task->attachments()->save($attachment);
                } else {
                    $project = Project::findOrFail($request->input('project_id'));
                    $attachment->file_path = $file->store('attachments/projects', 'public');
                    $project->attachments()->save($attachment);
                }
                $attachments[] = $attachment;
            }

            return response()->json([
                'status' => count($attachments) > 0 ? true : false,
                'message' => count($attachments) > 0 ? "File Added Successfully" : "File Added Failed!"
            ], count($attachments) > 0 ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Attachment $attachment)
    {
        return Storage::download($attachment->file_path, $attachment->file_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        $deleted = $attachment->delete();
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'attachment Deleted Successfully' : 'attachment Deleted Failed!',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}