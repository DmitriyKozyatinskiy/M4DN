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

  protected function save(Request $data)
  {
    $user = Auth::user();
    $user->name = $data->name;
    $user->email = $data->email;
    $user->save();

    return redirect()->route('account/settings');
  }

  protected function setAdmin($id)
  {
    $user = Auth::user();
    $user->isAdmin = true;
    $user->save();

    return true;
  }
}
