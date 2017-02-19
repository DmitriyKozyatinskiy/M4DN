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

  protected function save(Request $data)
  {
    $device = $data->id ? Device::find($data->id) : new Device();
    $device->name = $data->name;
    $device->userAgent = $data->useCurrentUserAgent ? $data->header('User-Agent') : $data->userAgent;
    $user = Auth::user();
    $device->user()->associate($user);
    $device->save();

    return redirect()->route('devices/show');
  }

  protected function delete(Request $data)
  {
    $devices = Auth::user()->devices;
    $devices->find($data->id)->delete();

    return redirect()->route('devices/show');
  }
}
