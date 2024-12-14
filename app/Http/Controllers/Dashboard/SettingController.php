<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class SettingController extends BaseController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('Read-Settings', user());
        return view('dashboard.settings.index', ['setting' => Setting::first()]);
    }

    public function update(UpdateSettingRequest $updateSettingRequest)
    {
        $this->authorize('Update-Settings', user());

        $setting = Setting::first();

        $updateSettingRequest->validated();

        if ($setting) {

            $imageName = $setting->logo;

            if ($updateSettingRequest->hasFile('logo')) {
                if ($setting->logo) {
                    Storage::delete($setting->logo);
                }
                $imageName = $updateSettingRequest->file('logo');
                $imageName = $imageName->store('setting');
                $setting->logo = $imageName;
                $setting->save();
            }

            $setting->update([
                'name' => $updateSettingRequest->input('name'),
                'email' => $updateSettingRequest->input('email'),
                'phone' => $updateSettingRequest->input('phone'),
                'address' => $updateSettingRequest->input('address'),
                'logo' => $imageName
            ]);

            return redirect()->back()->with('message', 'Settings Updated Successfully');
        } else {
            $imageName = null;
            if ($updateSettingRequest->hasFile('logo')) {
                $imageName = $updateSettingRequest->file('logo');
                $imageName = $imageName->store('setting', ['disk' => 'public']);
            }
            Setting::create([
                'name' => $updateSettingRequest->input('name'),
                'email' => $updateSettingRequest->input('email'),
                'phone' => $updateSettingRequest->input('phone'),
                'address' => $updateSettingRequest->input('address'),
                'logo' => $imageName
            ]);
            return redirect()->back()->with('message', 'Settings Created Successfully');
        }
    }
}
