<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
      'password' => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->password = $request->password;
    $user->save();

    return redirect()->route('account/settings')->with('settings-change-success', 'Profile updated!');
  }

  protected function setAdmin()
  {
    $user = Auth::user();
    $user->isAdmin = true;
    $user->save();

    return redirect()->route('home');
  }
}
