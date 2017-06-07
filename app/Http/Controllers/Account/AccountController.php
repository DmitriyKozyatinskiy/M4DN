<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function __construct()
  {
  }

  protected function save(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:25|string',
      'timezone' => 'required|timezone',
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->timezone = $request->timezone;
    $user->save();

    return redirect()->route('account/settings')->with('settings-change-success', 'Profile updated!');
  }

  protected function changePassword(Request $request)
  {
    $this->validate($request, [
      'password' => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();
    $user->password = bcrypt($request->password);
    $user->save();

    return redirect()->route('account/settings')->with('settings-change-success', 'Password updated!');
  }

  protected function show()
  {
    $user = Auth::user();
    $timezone = $user->timezone;

    return view('account/settings', ['timezone' => $timezone]);
  }

  protected function setAdmin()
  {
    $user = Auth::user();
    $user->isAdmin = true;
    $user->save();

    return redirect()->route('home');
  }

  protected function setSubscription()
  {
    $clientToken = \Braintree_ClientToken::generate();
    $user = Auth::user();
    $customer = \Braintree_Customer::create([
      'email' => 'mike.jones@example.com'
    ]);
    dump($customer->customer->id);
    // $user->newSubscription('Basic', 'monthly')->create($clientToken);
  }
}
