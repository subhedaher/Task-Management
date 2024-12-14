<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductivityResource;
use App\Models\Productivity;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductivityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Productivity::class, 'productivity');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productivities = Productivity::orderBy('created_at', 'desc')->paginate(10);
        return ProductivityResource::collection($productivities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            $productivity = new Productivity();
            $productivity->task_id = $request->input('task_id');
            $productivity->name = $request->input('name');
            $productivity->start = $request->input('start');
            $productivity->end = $request->input('end');
            $productivity->description = $request->input('description');
            $productivity->member_id = $request->user()->id;
            $productivity->save();
            return response()->json([
                'status' => $productivity ? true : false,
                'message' => $productivity ? 'Productivity Created Successfully' : 'Productivity Created Failed!',
            ], $productivity ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
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
    public function show(Productivity $productivity)
    {
        return response()->json([
            'status' => true,
            'data' => new ProductivityResource($productivity),
        ], Response::HTTP_OK);
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
}