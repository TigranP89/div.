<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function adminLogin(Request $request)
  {
  /*
   * Request Body:
   * {
   *   "email": "Admin email",
   *   "password": "Admin password"
   * }
   */
    try {
      $dataAttempt = array(
        'email'=>$request->input('email'),
        'password'=>$request->input('password'),
      );

      if (Auth::attempt($dataAttempt)){
        if (Auth::user()->isAdmin == true){
          $token = "Bearer " . Auth::user()->createToken($request->input('email'))->plainTextToken;

          return response()->json([
            "status" => 200,
            "message" => "Admin login successfully",
            "token" => $token,
          ]);
        }
      }

      return response()->json([
        "status" => 400,
        "message" => "Invalid credentials"
      ]);
    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function userLogin(Request $request)
  {
  /*
   * Request Body:
   * {
   *   "email": "User email",
   *   "password": "User password"
   * }
   */
    try {
      $dataAttempt = array(
          'email'=>$request->input('email'),
          'password'=>$request->input('password'),
      );

      if (Auth::attempt($dataAttempt)){
        if (Auth::user()->isAdmin == false){
          $token = "Bearer " . Auth::user()->createToken($request->input('email'))->plainTextToken;

          return response()->json([
            "status" => 200,
            "message" => "User login successfully",
            "token" => $token
          ]);
        }
      }

      return response()->json([
        "status" => 400,
        "message" => "Invalid credentials"
      ]);
    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function userRegister(Request $request)
  {
  /*
   * Request Body:
   * {
   *   "name": "New user name",
   *   "password": "User account password",
   *   "email": "New user email",
   * }
   */
    try {
      $validator = Validator::make($request->all(), [
        "name"=>["required"],
        "email"=>["required","email", "unique:users"],
        "password"=>["required"]
      ]);

      if ($validator->fails()){
        return response()->json([
          'error'=>$validator->errors()
        ]);
      } else {
        User::create([
          "email"=>$request->input('email'),
          "password"=>bcrypt($request->input('password')),
          "name"=>$request->input('name'),
          "isAdmin"=>0,
        ]);

        if(Auth::attempt(['email'=>$request->input('email'),"password"=>$request->input('password')])){
          $token = "Bearer " . Auth::user()->createToken("Bearer")->plainTextToken;
          return response()->json([
            "status" => 200,
            "message" => "User register successfully",
            "token" => $token
          ]);
        }
      }
    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }
}
