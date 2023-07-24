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
use App\Http\Controllers\API\AccessibilityController;
use App\Http\Controllers\API\AccountRetaggingController;
use App\Http\Controllers\API\AmortizationController;
use App\Http\Controllers\API\ChartOfAccountsController;
use App\Http\Controllers\API\GLController;
use App\Http\Controllers\BorrowerLoginController;
use App\Http\Controllers\API\EODController;
use App\Http\Controllers\API\DeductionController;
use App\Http\Controllers\API\JournalEntryController;
use App\Http\Resources\Borrower;


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
Route::post('borrower_login', [AuthController::class, 'borrowerLogin'])->name('api.borrowerLogin');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('center', CenterController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('borrower', BorrowerController::class);
    Route::resource('accountofficer', AccountOfficerController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('accessibility', AccessibilityController::class);
    Route::resource('chart', ChartOfAccountsController::class);
    Route::resource('gl', GLController::class);
    Route::resource('deduction', DeductionController::class);


    Route::get('borrower/accounts/{borrower_id}', [BorrowerController::class, 'getBorrowerAccounts']);

    Route::get('get-current-amortization/{branch_id}', [AmortizationController::class, 'getCurrentAmortization']);



    Route::get('accountofficer/getActivesInBranch/{branch_id}', [AccountOfficerController::class, "getActiveInBranch"]);
    Route::get('branches/activeBranch', [BranchController::class, 'activeBranch']);
    Route::get('centers/activeCenters/', [CenterController::class, 'activeCenter']);
    Route::get('products/activeProducts/', [ProductController::class, 'activeProduct']);

    // override payment list
    Route::post('payment/list/', [PaymentController::class, 'overridePaymentList']);
    Route::post('payment/override/', [PaymentController::class, 'overridePayment']);
    Route::get('payment/summary/{branch}', [PaymentController::class, 'paymentSummary']);
    Route::delete('payment/delete/{id}', [PaymentController::class, 'destroy']);
    Route::get('payment/cancel/{id}', [PaymentController::class, 'cancel']);
    Route::post('payment/overridelist/{id}', [PaymentController::class, 'overrideList']);
    Route::post('payment/paymentlist/', [PaymentController::class, 'cancelPaymentList']);


    // loan account
    Route::get('account/show/{account}', [LoanAccountController::class, 'showLoanAccount']);
    Route::get('account/amortization_details/{account}', [LoanAccountController::class, 'showCurrentAmortization']);
    Route::get('account/amortizations/{account}', [AmortizationController::class, 'getAmortizations']);
    Route::post('account/amortizations/update/{amortization}', [AmortizationController::class, 'update']);


    Route::post('account/create/{borrower}', [LoanAccountController::class, 'createLoanAccount']);
    Route::post('account/update/{account}', [LoanAccountController::class, 'updateLoanAccount']);
    Route::get('account/statement/{borrower}', [LoanAccountController::class, 'statement']);

    Route::get('account/remaining_balance/{account}', [LoanAccountController::class, 'getRemainingBalance']);

    //Update Co-Maker
    Route::post('account/updatecomaker/{account}', [LoanAccountController::class, 'updateCoMaker']);
    Route::post('account/updatepayment/{payment}', [PaymentController::class, 'updatePayment']);


    // override release
    Route::post('account/overrrideaccounts', [LoanAccountController::class, 'overrideAccountList']);
    Route::post('account/releasedaccounts', [LoanAccountController::class, 'releasedAccountList']);
    // cash voucher
    Route::get('account/cashvoucher/{account}', [LoanAccountController::class, 'cashVoucher']);


    Route::post('account/update-account-amortization/{account}', [LoanAccountController::class, 'updateAccountAmortization']);

    Route::post('account/retag-list/{branch}', [AccountRetaggingController::class, 'retagList']);


    Route::post('account/override/', [LoanAccountController::class, 'override']);
    Route::delete('account/remove/{account}', [LoanAccountController::class, 'delete']);
    Route::put('account/reject/{account}', [LoanAccountController::class, 'reject']);
    Route::delete('account/delete/{id}', [LoanAccountController::class, 'destroy']);
    // rejected release
    Route::get('account/rejected/{branch_id}', [LoanAccountController::class, 'rejectedAccountList']);
    // Route::get('account/create-amortization/{account}', [LoanAccountController::class, 'createAmortizationSched']);
    Route::post('account/generate-amortization/', [LoanAccountController::class, 'generateAmortizationSched']);
    Route::post('account/generate-sme/', [LoanAccountController::class, 'generateSMESched']);
    // promissory number
    Route::post('account/promissoryno/', [LoanAccountController::class, 'getPromissoryNo']);

    // reports
    Route::post('report/transaction/', [ReportsController::class, 'transactionReports']);
    Route::post('report/release/', [ReportsController::class, 'releaseReports']);
    Route::post('report/repayment/', [ReportsController::class, 'repaymentReports']);
    Route::post('report/branch/', [ReportsController::class, 'branchReports']);
    Route::post('report/consolidated/', [ReportsController::class, 'consolidatedReports']);
    Route::post('report/micro/', [ReportsController::class, 'microReports']);
    Route::post('report/bir/', [ReportsController::class, 'birTaxReport']);
    Route::post('report/prepaid/', [ReportsController::class, 'prepaidReport']);
    Route::post('report/savejournalenttry', [JournalEntryController::class, 'store']);
    Route::get('report/journal-entries', [JournalEntryController::class, 'index']);




    Route::post('uploadfile/{id}', [LoanAccountController::class, 'uploadFile']);

    Route::get('eod/eodtransaction/{branch_id}', [EODController::class, 'getTransactionDate']);
    Route::post('eod/eodtransaction/create', [EODController::class, 'createTransactionDate']);
    Route::post('eod/eodtransaction/check', [EODController::class, 'checkPendingTransctions']);
    Route::post('eod/eodtransaction/exec', [EODController::class, 'endOfTransaction']);
    Route::post('eod/eodtransaction/closewithouttransactions', [EODController::class, 'endDayWithoutTransactions']);

    Route::post('deduction/calculate', [DeductionController::class, 'calculateDeductions']);

    Route::get('borrower/list/{branch_id}', [BorrowerController::class, "borrowerList"]);

    Route::get('migrate/loanAccount', [LoanAccountController::class, "fixShortAdv"]);
    Route::get('migrate/payment/rebatesInterestPenaltyPDI', [LoanAccountController::class, "fixMiragtionRebates"]);
});

// Route::resource('borrower', BorrowerController::class);
// Route::resource('products', ProductController::class);
// Route::resource('centers', CenterController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
