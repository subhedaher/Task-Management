<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCommentResource;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskCommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskComment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = TaskComment::all();
        return TaskCommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
            'member_id' => 'required|numeric|exists:members,id',
            'comment' => 'required|string',
        ], [
            'task_id.required' => 'The task field is required.',
            'member_id.required' => 'The member is required.',
        ]);

        if (!$validator->fails()) {
            $comment = TaskComment::create($request->all());
            return response()->json([
                'status' => $comment ? true : false,
                'message' => $comment ? 'Comment Added Successfully' : 'Comment Added Failed!',
            ], $comment ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(TaskComment $comment)
    {
        return response()->json([
            'status' => true,
            'data' => new TaskCommentResource($comment),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComment $comment)
    {
        $validator = validator($request->all(), [
            'comment' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $updated = $comment->update($request->all());
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Comment Updated Successfully' : 'Comment Updated Failed!',
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
    public function destroy(TaskComment $comment)
    {
        $deleted = $comment->delete();
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Comment Deleted Successfully' : 'Comment Deleted Failed!',
        ], Response::HTTP_OK);
    }
}
