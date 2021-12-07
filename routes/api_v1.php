<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']); /* Register route */
Route::post('login', [AuthController::class, 'login']); /* Login route */

Route::middleware('auth:api')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']); /* Logout route */
    Route::get('me', [AuthController::class, 'getAuthCustomer']); /* Get current auth user information */

    // Customer routes
    Route::get('customers', [CustomerController::class, 'index']); /* Fetch all customers */
    Route::post('customer/create', [CustomerController::class, 'store']); /* Create new customers */
    Route::get('customer/{id}', [CustomerController::class, 'show']); /* Fetch single customer */
    Route::patch('customer/edit/{id}', [CustomerController::class, 'update']); /* Update single customer */
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy']); /* Remove single customer */

    // Role routes
    Route::post('role/assign', [RoleController::class, 'assignRole']); /* assign role route */
    

});
