<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('Read-Settings', $request->user());
        $settings = Setting::first();
        return new SettingResource($settings);
    }

    public function update(Request $request)
    {
        $this->authorize('Update-Settings', $request->user());
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,png'
        ]);

        if (!$validator->fails()) {
            $updated = Setting::first()->update($request->all());

            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Settings Updated Successfully' : 'Settings Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
