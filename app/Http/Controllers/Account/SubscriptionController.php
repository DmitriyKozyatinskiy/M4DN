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

    $braintreeCustomer = \Braintree_Customer::find($user->braintree_id);
    $paymentMethods = \collect($braintreeCustomer->paymentMethods);
    $defaultPaymentMethod = $paymentMethods->where('default', true)->first();
    $isPayPal = ($defaultPaymentMethod && !isset($defaultPaymentMethod->last4));

    $clientToken = \Braintree_ClientToken::generate();
    if (!$currentBraintreePlan) {
      $currentBraintreePlan = $braintreePlans->where('price', '0.00')->first();
      $currentBraintreePlan->braintree_plan = $currentBraintreePlan->id;
    }

    return view('account/subscription', [
      'braintreeToken' => $clientToken,
      'cardLastFour' => (!$defaultPaymentMethod || $isPayPal) ? null : $defaultPaymentMethod->last4,
      'cardType' => $isPayPal ? null : $user->card_type,
      'currentBraintreePlan' => $currentBraintreePlan,
      'braintreePlans' => $braintreePlans,
      'isPayPal' => $isPayPal,
      'firstName' => $braintreeCustomer->firstName,
      'lastName' => $braintreeCustomer->lastName,
    ]);
  }
}
