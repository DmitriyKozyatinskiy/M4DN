<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions;
use App\User;
use Illuminate\Auth\Events\Registered;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Plan;

class AuthenticateController extends Controller
{
  use RegistersUsers;

  public function authenticate(Request $request)
  {
    // grab credentials from the request
    $credentials = $request->only('email', 'password');

    try {
      // attempt to verify the credentials and create a token for the user
      if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json([
          'status' => 401,
          'statusText' => 'Invalid credentials',
          'isSuccess' => false
        ], 401);
      }
    } catch (JWTException $e) {
      // something went wrong whilst attempting to encode the token
      return response()->json([
        'status' => 500,
        'statusText' => 'Could not create token',
        'isSuccess' => false
      ], 500);
    }

    // all good so return the token
    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('token'),
      'isSuccess' => true
    ], 200);
  }


  public function getAuthenticatedUser()
  {
    try {
      if (!$user = JWTAuth::parseToken()->authenticate()) {
        return response()->json([
          'status' => 404,
          'statusText' => 'User not found',
          'isSuccess' => false
        ], 404);
      }
    } catch (Exceptions\TokenExpiredException $e) {
      return response()->json([
        'status' => $e->getStatusCode(),
        'statusText' => 'Token expired',
        'isSuccess' => false
      ], $e->getStatusCode());
    } catch (Exceptions\TokenInvalidException $e) {
      return response()->json([
        'status' => $e->getStatusCode(),
        'statusText' => 'Token invalid',
        'isSuccess' => false
      ], $e->getStatusCode());
    } catch (Exceptions\JWTException $e) {
      return response()->json([
        'status' => $e->getStatusCode(),
        'statusText' => 'Token absent',
        'isSuccess' => false
      ], $e->getStatusCode());
    } catch (Exception $e) {
      return response()->json([
        'status' => $e->getMessage(),
        'statusText' => 'Unknown error',
        'isSuccess' => false
      ], 500);
    }
    // the token is valid and we have found the user via the sub claim
    return response()->json([
      'status' => 200,
      'statusText' => 'OK',
      'data' => compact('user'),
      'isSuccess' => true
    ], 200);
  }


  public function registration(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:25|string',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
      'subscribe' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => '401',
        'statusText' => 'Unknown error',
        'isSuccess' => false,
        'errors' => $validator->messages()
      ], 500);
    }

    $user = User::create([
      'name' => $request['name'],
      'email' => $request['email'],
      'password' => bcrypt($request['password']),
      'is_subscription_required' => $request['subscribe'],
      'api_token' => str_random(60)
    ]);

//    $freePlan = Plan::where('price', 0)->first();
//    if ($freePlan) {
//      $user->plan()->associate($freePlan);
//    }

    $user->confirmation_code = str_random(30);
    $user->save();
    event(new Registered($user));
    $this->notifyUser($user);

//    $credentials = $request->only('name', 'email', 'password', 'passwordConfirm');
//
//    if ($credentials['password'] !== $credentials['password_confirmation']) {
//      return response()->json([
//        'status' => 401,
//        'statusText' => 'Passwords don`t match',
//        'isSuccess' => false
//      ], 401);
//    }
//
//    try {
//      $user = User::create([
//        'name' => $credentials['name'],
//        'email' => $credentials['email'],
//        'password' => bcrypt($credentials['password']),
//        'api_token' => str_random(60)
//      ]);
//    } catch (Exception $e) {
//      return response()->json([
//        'status' => $e->getMessage(),
//        'statusText' => 'Unknown error',
//        'isSuccess' => false
//      ], 500);
//    }

    return response()->json([
      'status' => 200,
      'statusText' => 'Confirmation email was send',
      'data' => compact('user'),
      'isSuccess' => true
    ], 200);
  }
}
