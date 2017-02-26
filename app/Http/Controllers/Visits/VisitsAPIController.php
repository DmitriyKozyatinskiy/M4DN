<?php

namespace App\Http\Controllers\Visits;

use App\Visit;
use App\Device;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;

class VisitsAPIController extends Controller
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

    $visits = $user->visits;
    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('visits'),
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

    $device = Device::where([
      ['id', '=', $data->deviceID],
      ['user_id', '=', $user->id],
    ])->first();

    //$user->devices->get([ 'id' => (int)$data->deviceID ]);
    if (!$device) {
      return response()->json([
        'status' => 403,
        'statusText' => 'Device not found',
        'isSuccess' => false
      ], 403);
    }
    $visit = new Visit();
    $visit->title = $data->title;
    $visit->url = $data->url;
    $visit->user()->associate($user);
    $visit->device()->associate($device);
    $visit->save();

    return response()->json([
      'status' => 200,
      'statusText' => 'Visit is saved',
      'data' => compact('visit'),
      'isSuccess' => true
    ], 200);
  }
}
