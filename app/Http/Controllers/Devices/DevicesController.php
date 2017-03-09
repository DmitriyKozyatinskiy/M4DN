<?php

namespace App\Http\Controllers\Devices;

use Auth;
use App\Device;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
  public function __construct()
  {
  }

  protected function show()
  {
    $devices = Auth::user()->devices;

    return view('devices/show', ['devices' => $devices]);
  }

  protected function update($id)
  {
    $device = $id ? Device::find($id) : new Device();
    return view('devices/update', ['device' => $device]);
  }

  protected function save(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30'
    ]);

    $device = $request->id ? Device::find($request->id) : new Device();
    $device->name = $request->name;
    $device->userAgent = $request->useCurrentUserAgent ? $request->header('User-Agent') : $request->userAgent;
    $user = Auth::user();
    $device->user()->associate($user);
    $device->save();

    return redirect()->route('devices/show')->with('device-save-success', 'Device is saved!');
  }

  protected function delete(Request $data)
  {
    $devices = Auth::user()->devices;
    $devices->find($data->id)->delete();

    return redirect()->route('devices/show');
  }
}
