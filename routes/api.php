<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BorrowerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CenterController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\CenterController;
use App\Http\Controllers\API\AccountOfficerController;

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

# authentication
Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('product', ProductController::class);
    Route::resource('center', CenterController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('accountofficer', AccountOfficerController::class);
});
Route::resource('products', ProductController::class);
Route::resource('centers', CenterController::class);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });