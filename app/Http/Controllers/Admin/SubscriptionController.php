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

  protected function show($id)
  {
    $plan = Plan::find($id);

    return view('admin/subscription', ['plan' => $plan]);
  }

  protected function save(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30',
      'hours' => 'required|numeric',
      'price' => 'required|numeric',
      'description' => 'required|max:255'
    ]);

    $plan = $request->id ? Plan::find($request->id) : new Plan();
    $plan->name = $request->name;
    $plan->devices = 10; //$data->devices;
    $plan->hours = $request->hours;
    $plan->price = $request->price ? $request->price : 0;
    $plan->description = $request->description;
    $plan->save();

    //return $this->show($plan->id);

    return redirect()->route('subscription/show')->with('subscription-save-success', 'Subscription is saved!');
  }
}
