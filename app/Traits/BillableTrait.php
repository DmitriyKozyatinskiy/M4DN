<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Arr;
use Braintree\PayPalAccount;
use Braintree\Customer as BraintreeCustomer;
use Braintree\Transaction as BraintreeTransaction;
use Braintree\Subscription as BraintreeSubscription;

trait BillableTrait
{
  /**
   * Create a Braintree customer for the given model.
   *
   * @param  string  $token
   * @param  array  $options
   * @return \Braintree\Customer
   */
  public function createAsBraintreeCustomerTrait($token, array $options = [])
  {
    $response = BraintreeCustomer::create(
      array_replace_recursive([
        'firstName' => Arr::get(explode(' ', $this->name), 0),
        'lastName' => Arr::get(explode(' ', $this->name), 1),
        'email' => $this->email,
        'paymentMethodNonce' => $token,
        'creditCard' => [
          'options' => [
            'verifyCard' => true,
          ],
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
