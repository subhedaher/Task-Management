<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreProductivityRequest;
use App\Http\Resources\ProductivityResource;
use App\Models\Productivity;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class ProductivityController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Productivity::class, 'productivity');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user('admin')) {
            $productivities = Productivity::orderBy('created_at', 'desc')->paginate(10);
        } else {
            if ($request->user()->hasRole('Project Manager')) {
                $projectsId = user()->projects->pluck('id');
                $tasksid = Task::whereIn('project_id', $projectsId)->pluck('id');
                $productivities = Productivity::whereIn('task_id', $tasksid)->orderBy('created_at', 'desc')->paginate(10);
            } elseif ($request->user()->hasRole('Member')) {
                $productivities = Productivity::where('member_id', '=', user()->id)->orderBy('created_at', 'desc')->paginate(10);
            }
        }
        return view('dashboard.productivities.index', ['productivities' => $productivities]);
    }

    public function create()
    {
        $tasksId = TaskMember::where('member_id', '=', user()->id)->pluck('task_id');

        $projects = Project::whereIn('id', Task::whereIn('id', $tasksId)->pluck('project_id'))->get();

        return view('dashboard.productivities.create', ['projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductivityRequest $storeProductivityRequest)
    {
        $storeProductivityRequest->validated();

        Productivity::create([
            'name' => $storeProductivityRequest->input('name'),
            'task_id' => $storeProductivityRequest->input('task_id'),
            'description' => $storeProductivityRequest->input('description'),
            'start' => $storeProductivityRequest->input('start'),
            'end' => $storeProductivityRequest->input('end'),
            'member_id' => user('member')->id
        ]);

        return redirect()->back()->with('message', 'Productivity Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Productivity $productivity)
    {
        $productivity = new ProductivityResource($productivity);
        return response()->json($productivity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productivity $productivity)
    {
        $validator = validator($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
            'name' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
            'description' => 'required|string',
        ], [
            'task_id.required' => 'The task field is required.',
        ]);

        if (!$validator->fails()) {
            $updated = $productivity->update($request->all());
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Productivity Updated Successfully' : 'Productivity Updated Failed!',
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
    public function destroy(Productivity $productivity)
    {
        $deleted = $productivity->delete();
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Productivity Deleted Successfully' : 'Productivity Deleted Failed!',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function taskFilterCreate($id)
    {
        $project = Project::find($id);

        $taskIds = Task::where('project_id', $project->id)->pluck('id');

        $memberTaskIds = TaskMember::whereIn('task_id', $taskIds)
            ->where('member_id', user()->id)
            ->pluck('task_id');

        $tasks = Task::whereIn('id', $memberTaskIds)->get();

        return response()->json($tasks);
    }
}
