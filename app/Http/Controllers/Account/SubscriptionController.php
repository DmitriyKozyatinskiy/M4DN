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

  protected function setActive(Request $request)
  {
    $user = Auth::user();
    if ($user->subscribed('main')) {
      $user->subscription('main')->swap($request->subscription_id);
    } else {
      $braintreePlan = collect(\Braintree_Plan::all())->where('id', $request->subscription_id)->first();
      if ($braintreePlan) {
        $nonce = \Braintree_PaymentMethodNonce::create($user->braintree_payment_token);
        $user->newSubscription('main', $braintreePlan->id)->create($nonce->paymentMethodNonce->nonce);
      }
    }

    return redirect()->route('subscription/show')->with('subscription-save-success', 'Subscription changed!');
  }

  protected function show()
  {
    $user = Auth::user();
    $braintreePlans = \Braintree_Plan::all();
    uasort($braintreePlans, function($a, $b) {
      return ($a->price <= $b->price) ? -1 : 1;
    });
    $braintreePlans = collect($braintreePlans);
    $currentBraintreePlan = $user->subscriptions()->first();

    $clientToken = \Braintree_ClientToken::generate();
    if (!$currentBraintreePlan) {
      $currentBraintreePlan = $braintreePlans->where('price', '0.00')->first();
      $currentBraintreePlan->braintree_plan = $currentBraintreePlan->id;
    }

    return view('account/subscription', [
      'braintreeToken' => $clientToken,
      'cardLastFour' => $user->card_last_four,
      'cardType' => $user->card_type,
      'currentBraintreePlan' => $currentBraintreePlan,
      'braintreePlans' => $braintreePlans,
    ]);
  }
}
