<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BorrowerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CenterController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\AccountOfficerController;
use App\Http\Controllers\API\LoanAccountController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReportsController;


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


Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('center', CenterController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('borrower', BorrowerController::class);
    Route::resource('accountofficer', AccountOfficerController::class);
    Route::resource('payment', PaymentController::class);

    // override payment list
    Route::post('payment/list/', [PaymentController::class, 'overridePaymentList']);
    Route::post('payment/override/', [PaymentController::class, 'overridePayment']);

    // loan account
    Route::get('account/show/{account}', [LoanAccountController::class, 'showLoanAccount']);
    Route::post('account/create/{borrower}', [LoanAccountController::class, 'createLoanAccount']);
    Route::put('account/update/{account}', [LoanAccountController::class, 'updateLoanAccount']);

    // override release
    Route::post('account/overrrideaccounts', [LoanAccountController::class, 'overrideAccountList']);

    Route::post('account/override/', [LoanAccountController::class, 'override']);
    Route::delete('account/remove/{account}', [LoanAccountController::class, 'delete']);
    Route::put('account/reject/{account}', [LoanAccountController::class, 'reject']);
    Route::delete('account/delete/{id}', [LoanAccountController::class, 'destroy']);
    // rejected release
    Route::get('account/rejected/', [LoanAccountController::class, 'rejectedAccountList']);
    Route::get('account/create-amortization/{account}', [LoanAccountController::class, 'createAmortizationSched']);
    Route::post('account/generate-amortization/', [LoanAccountController::class, 'generateAmortizationSched']);
    // promissory number
    Route::post('account/promissoryno/', [LoanAccountController::class, 'getPromissoryNo']);

    // reports
    Route::post('report/transaction/', [ReportsController::class, 'transactionReports']);
    Route::post('report/release/', [ReportsController::class, 'releaseReports']);
    // Route::post('report/repayment/', [ReportsController::class, 'repaymentReports']);

});

// Route::resource('products', ProductController::class);
// Route::resource('centers', CenterController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });