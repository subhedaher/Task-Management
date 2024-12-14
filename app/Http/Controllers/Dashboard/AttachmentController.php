<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class AttachmentController extends BaseController
{

    use AuthorizesRequests;

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

    public function show(Attachment $attachment)
    {
        $filePath = $attachment->file_path;

        if (!Storage::exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $fileName = pathinfo($attachment->file_name, PATHINFO_FILENAME);

        $extension = pathinfo($attachment->file_path, PATHINFO_EXTENSION);

        return Storage::download($filePath, $fileName . '.' . $extension);
    }

    public function view(Attachment $attachment)
    {
        $filePath = $attachment->file_path;

        if (!Storage::exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $fileContent = Storage::get($filePath);
        $mimeType = Storage::mimeType($filePath);

        return response($fileContent)
            ->header('Content-Type', $mimeType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {

        if (!Storage::exists($attachment->file_path)) {
            return response()->json(['message' => 'File not found.'], 404);
        }
        $attachment->delete();
        return redirect()->back()->with('message', 'Deleted File Successfully');
    }
}
