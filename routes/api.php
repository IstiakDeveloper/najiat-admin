<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
// use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;




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

Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/register', [CustomerController::class, 'register']);
// Route::post('/login', [CustomerController::class, 'login']);
// Route::get('/check-authentication', [AuthController::class, 'checkAuthentication']);

Route::get('/customer/orders', [OrderController::class, 'index']);
Route::get('/customer/orders/{order}', [OrderController::class, 'show']);

// Register, login, and check authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/check-authentication', [AuthController::class, 'checkAuthentication']);


Route::middleware('auth:api')->group(function () {
    // Define your protected routes here
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
