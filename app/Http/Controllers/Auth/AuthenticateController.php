<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions;

class AuthenticateController extends Controller
{
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
}
