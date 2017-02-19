<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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

  protected function save(Request $data)
  {
    $plan = $data->id ? Plan::find($data->id) : new Plan();
    $plan->name = $data->name;
    $plan->devices = $data->devices;
    $plan->days = $data->days;
    $plan->price = $data->price;
    $plan->save();

    return redirect()->route('subscription/show');
  }
}
