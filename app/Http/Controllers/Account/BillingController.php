<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class BillingController extends Controller
{
  public function __construct()
  {
  }

  protected function save(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json([
        'status' => 401,
        'statusText' => 'Unauthorized',
        'isSuccess' => false
      ], 401);
    }

    $data = $request->nonce;

    try {
      $user = Auth::user();
//      $result = \Braintree_PaymentMethod::create([
//        'customerId' => $user->braintree_id,
//        'paymentMethodNonce' => $request->nonce,
//        'options' => [
//          'verifyCard' => true
//        ]
//      ]);
      $user->createAsBraintreeCustomerTrait($request->nonce, [
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
      ], $request->address);
      // $user->braintree_payment_token = $request->nonce;
      $user->save();
    } catch (Exception $e) {
      return response()->json([
        'status' => $e->getMessage(),
        'statusText' => 'Unknown error',
        'isSuccess' => false,
        'data' => compact('data')
      ], 500);
    }

    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('result'),
      'isSuccess' => true
    ], 200);
  }

  public function show(Request $request)
  {
    $clientToken = \Braintree_ClientToken::generate();
    return view('account/billing', [
      'braintreeToken' => $clientToken,
      'cardLastFour' => Auth::user()->card_last_four
    ]);
  }
}
