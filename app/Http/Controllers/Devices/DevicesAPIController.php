<?php

namespace App\Http\Controllers\Devices;

use App\Device;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;

class DevicesAPIController extends Controller
{
  public function __construct()
  {
  }

  public function get()
  {
    try {
      $user = JWTAuth::parseToken()->authenticate();
    } catch (Exception $e) {
      return response()->json([
        'status' => 401,
        'statusText' => 'Unauthorized',
        'isSuccess' => false
      ], 401);
    }

    $devices = $user->devices;
    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('devices'),
      'isSuccess' => true
    ], 200);
  }

  public function create(Request $data)
  {
    try {
      $user = JWTAuth::parseToken()->authenticate();
    } catch (Exception $e) {
      return response()->json([
        'status' => 401,
        'statusText' => 'Unauthorized',
        'isSuccess' => false
      ], 401);
    }

    $device = new Device();
    $device->name = $data->name;
    $device->userAgent = $data->header('User-Agent');
    $device->user()->associate($user);
    $device->save();
    return response()->json([
      'status' => 200,
      'statusText' => 'Device is saved',
      'data' => compact('device'),
      'isSuccess' => true
    ], 200);
  }
}
