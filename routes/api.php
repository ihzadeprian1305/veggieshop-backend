<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VegetableController;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\callback;

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

// Default Route
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// This Middleware Route can be Accessed after Login or Register
Route::middleware('auth:sanctum')->group((function(){
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('transaction', [TransactionController::class, 'all']);
    Route::post('transaction/{id}', [TransactionController::class, 'update']);
    
    Route::post('checkout', [TransactionController::class, 'checkout']);
}));

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('vegetable', [VegetableController::class, 'all']);

Route::post('midtrans/callback', [MidtransController::class, 'callback']);