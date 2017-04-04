<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Arr;
use Braintree\PayPalAccount;
use Braintree\Customer as BraintreeCustomer;
use Braintree\Transaction as BraintreeTransaction;
use Braintree\Subscription as BraintreeSubscription;
use Auth;

trait BillableTrait
{
  /**
   * Create a Braintree customer for the given model.
   *
   * @param  string  $token
   * @param  array  $options
   * @return \Braintree\Customer
   */
  public function createAsBraintreeCustomerTrait($token, array $options = [], $address = null)
  {

//    $address = \Braintree_Address::create([
//      'customerId'        => Auth::user()->braintree_id,
//      'firstName'         => $options['firstName'],
//      'lastName'          => $options['lastName'],
//      'streetAddress'     => $options['address'],
//    ]);
//
//    var_dump($address);
//    throw new Exception('Unable to create Braintree customer: '.json_encode($address));

//    $user = Auth::user();
//    $customerUpdate = \Braintree_Customer::update(
//      $user->braintree_id,
//      [
//        'firstName' => $options['firstName'],
//        'lastName' => $options['lastName'],
//        'company' => 'New Company',
//        'email' => $user->email,
//        'extendedAddress' => $address
//      ]
//    );

    $response = BraintreeCustomer::create(
      array_replace_recursive([
        'firstName' => Arr::get(explode(' ', $this->name), 0),
        'lastName' => Arr::get(explode(' ', $this->name), 1),
        'email' => $this->email,
        'paymentMethodNonce' => $token,
        'creditCard' => [
          'options' => [
            'verifyCard' => true,
            'makeDefault' => true,
          ],
          'billingAddress' => [
            'firstName' => $options['firstName'],
            'lastName' => $options['lastName'],
            'extendedAddress' => $address,
          ]
        ],
      ], $options)
    );

    if (!$response->success) {
      throw new Exception('Unable to create Braintree customer: '.$response->message);
    }

    $paymentMethod = $response->customer->paymentMethods[0];

    $paypalAccount = $paymentMethod instanceof PayPalAccount;

    if ($response->customer->creditCards && $response->customer->creditCards[0]) {
      $paymentToken = $response->customer->creditCards[0]->token;
    } else {
      $paymentToken = null;
    }

    $this->forceFill([
      'braintree_id' => $response->customer->id,
      'paypal_email' => $paypalAccount ? $paymentMethod->email : null,
      'card_brand' => ! $paypalAccount ? $paymentMethod->cardType : null,
      'card_last_four' => ! $paypalAccount ? $paymentMethod->last4 : null,
      'braintree_payment_token' => $paymentToken,
    ])->save();

    return $response->customer;
  }
}
