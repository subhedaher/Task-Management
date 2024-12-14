<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\TaskCommentEvent;
use App\Http\Requests\StoreCommentRequest;
use App\Models\TaskComment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TaskCommentController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskComment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $storeCommentRequest)
    {
        $storeCommentRequest->validated();

        $comment = TaskComment::create($storeCommentRequest->all());

        if ($comment) {
            event(new TaskCommentEvent());
        }

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'member_id' => $comment->member_id,
                'member_name' => $comment->member->name === user()->name ? 'You' :$comment->member->name ,
                'created_at' => dateFormate2($comment->created_at),
                'time' => $comment->created_at->format('h:i a'),
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskComment $comment)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComment $comment)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskComment $comment)
    {
        // 
    }
}
