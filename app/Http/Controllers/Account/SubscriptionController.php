<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
  public function __construct()
  {
  }

  protected function setActive(Request $data)
  {
    $plan = Plan::find($data->subscriptionID);
    $user = Auth::user();
    $user->plan()->associate($plan);
    $user->save();

    return redirect()->route('subscription/show');
  }

  protected function show()
  {
    $plans = Plan::all()->sortBy('create_date');
    $currentPlan = Auth::user()->plan;
    if ($currentPlan) {
      $plans->where('id', $currentPlan->id)->isActive = true;
    }

    return view('account/subscription', ['plans' => $plans, 'currentPlan' => $currentPlan]);
  }
}
