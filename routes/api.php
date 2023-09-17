<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RequestEventController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function (){
  /*
   * Get all Requests
  */
  Route::get('requests', [RequestEventController::class, 'index']);
  /*
   * Change Requests with id
  */
  Route::put('requests/{id}', [RequestEventController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'user'])->group(function (){
  /*
   * Create Requests
  */
  Route::post('requests', [RequestEventController::class, 'store']);// Create Requests
});

Route::post("admin/login", [AuthController::class, 'adminLogin']);//Login as Admin
Route::post("user/login", [AuthController::class, 'userLogin']);//Login as USer
Route::post("user/register", [AuthController::class, 'userRegister']);//Register new user