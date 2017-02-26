<?php

namespace App\Http\Controllers\Visits;

use Auth;
use App\Visit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitsController extends Controller
{
  public function __construct()
  {
  }

  public function show()
  {
    $user = Auth::user();
    $visits = $user->visits->sortByDesc('created_at')->groupBy(function ($visit) {
      return Carbon::parse($visit->created_at)->format('Y-m-d');
    });

    return view('visits/show', ['visitGroups' => $visits]);
  }

  public function get()
  {
    $user = Auth::user();
    $visits = $user->visits;

    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('visits'),
      'isSuccess' => true
    ], 200);
  }
}
