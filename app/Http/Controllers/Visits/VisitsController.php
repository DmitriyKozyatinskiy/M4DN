<?php

namespace App\Http\Controllers\Visits;

use Auth;
use App\Visit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitsController extends Controller
{
  public function __construct()
  {
  }

  public function show(Request $request)
  {
    $user = Auth::user();
    $devices = $user->devices;

    return view('visits/show', ['devices' => $devices]);
  }

  public function get(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json([
        'status' => 401,
        'statusText' => 'Unauthorized',
        'isSuccess' => false
      ], 401);
    }

    $device = $request->device_id;
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $keyword = $request->keyword;

    $visits =
      Visit::where('user_id', $user->id)
        ->when($device, function ($query) use ($device) {
          return $query->where('device_id', $device);
        })
        ->when($keyword, function ($query) use ($keyword) {
          return $query->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('url', 'like', '%' . $keyword . '%');
        })
        ->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
          return $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->when(($startDate && !$endDate), function ($query) use ($startDate) {
          return $query->where('created_at', '>', $startDate);
        })
        ->when((!$startDate && $endDate), function ($query) use ($endDate) {
          return $query->where('created_at', '<', $endDate);
        })
        ->latest()
        ->offset($request->offset)
        ->limit(20)
        ->with('device')
        ->get()->groupBy(function ($visit) {
          return Carbon::parse($visit->created_at)->format('Y-m-d');
        });


//    $visits = $user->visits->sortByDesc('created_at')->groupBy(function ($visit) {
//      return Carbon::parse($visit->created_at)->format('Y-m-d');
//    });

    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('visits'),
      'isSuccess' => true
    ], 200);
  }
}