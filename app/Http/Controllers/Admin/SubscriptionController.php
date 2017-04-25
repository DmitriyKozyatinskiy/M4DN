<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }

  protected function show($braintree_id)
  {
    $savedPlan = Plan::where('braintree_id', $braintree_id)->first();
    if ($savedPlan) {
      $plan = $savedPlan;
      $hours = $plan->hours;
      $braintree_id = $plan->braintree_id;
    } else {
      $braintreePlans = \Braintree_Plan::all();
      $plan = collect($braintreePlans)->where('id', $braintree_id)->first();
      $braintree_id = $plan->id;
      $hours = null;
    }

    return view('admin/subscription', ['braintree_id' => $braintree_id, 'hours' => $hours]);
  }

  protected function save(Request $request)
  {
    $this->validate($request, [
      'hours' => 'required|numeric'
    ]);
    $plan = Plan::where('braintree_id', $request->braintree_id)->first();
    if ($plan) {
      $plan->hours = $request->hours;
      $plan->devices = 999;
      $plan->save();
    } else {
      $plan = new Plan();
      $plan->braintree_id = $request->braintree_id;
      $plan = new Plan([
        'braintree_id' => $request->braintree_id,
        'hours' => $request->hours,
        'devices' => 999,
      ]);
      $plan->save();
    }

    dump($plan);

    //return $this->show($plan->id);

    return true;//redirect()->route('subscription/show')->with('subscription-save-success', 'Subscription is saved!');
  }
}
