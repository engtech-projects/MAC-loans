<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductSetupController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ClientInformationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BorrowerLoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ClientPortalInformationController;
use App\Http\Controllers\EndOfDayController;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/borrower_login', [BorrowerLoginController::class, 'index'])->name('borrowerlogin');
Route::post('/borrower_login', [BorrowerLoginController::class, 'login']);

Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/branch', function(){
	return \App\Models\Branch::all();
});
Route::group(['middleware' => 'auth:borrowers'], function(){
	Route::get('borrower_logout', [BorrowerLoginController::class, 'logout'])->name('logout');
	Route::get('/borrower/personal_information', [ClientPortalInformationController::class, 'personalInformationDetails'])->name('borrower.personal_information');
	Route::get('/borrower/account_statement', [ClientPortalInformationController::class, 'accountStatementDetails'])->name('borrower.account_statement');
	Route::get('/borrower/balance_inquiry', [ClientPortalInformationController::class, 'balanceInquiry'])->name('borrower.balance_inquiry');
});
Route::group(['middleware' => 'auth'], function (){
	Route::get('logout', [LoginController::class, 'logout']);
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	
	Route::get('/client_information/personal_information_list', [ClientInformationController::class, 'personalInformationList'])->name('client_information.personal_information_list');
	Route::get('/client_information/personal_information_details/{id}', [ClientInformationController::class, 'personalInformationDetails'])->name('client_information.personal_information_details');
	Route::get('/client_information/statement_of_accounts_list', [ClientInformationController::class, 'statementOfAccountsList'])->name('client_information.statement_of_accounts_list');
	Route::get('/client_information/personal_information_details/edit/{id}', [ClientInformationController::class, 'personalInformationDetailsEdit'])->name('client_information.personal_information_details.edit');
	Route::get('/client_information/account_statement_details/{id}', [ClientInformationController::class, 'accountStatementDetails'])->name('client_information.account_statement_details');
	Route::get('/account/statement/{id}', [ClientInformationController::class, 'statement']);
	Route::get('/client_information/balance_inquiry/{id}', [ClientInformationController::class, 'balanceInquiry'])->name('client_information.balance_inquiry');
	Route::get('/client_information/balance_inquiry_list/', [ClientInformationController::class, 'balanceInquiryList'])->name('client_information.balance_inquiry_list');
	Route::post('/client_information/personal_information_details/delete/', [ClientInformationController::class, 'deleteOtherInfo']);
	
	Route::get('/maintenance/cancel_payments', [MaintenanceController::class, 'cancelPayments'])->name('maintenance.cancel_payments');
	Route::get('/maintenance/product_setup', [MaintenanceController::class, 'productSetup'])->name('maintenance.product_setup');
	Route::get('/maintenance/center_ao', [MaintenanceController::class, 'centerAo'])->name('maintenance.center_ao');
	Route::get('/maintenance/user_settings', [MaintenanceController::class, 'userSettings'])->name('maintenance.user_settings');
	Route::get('/maintenance/gl_setup', [MaintenanceController::class, 'glSetup'])->name('maintenance.gl_setup');
	Route::get('/maintenance/account_retagging', [MaintenanceController::class, 'accountRetagging'])->name('maintenance.account_retagging');
	Route::get('/maintenance/account_retagging/accounts', [MaintenanceController::class, 'retagList']);
	Route::get('/maintenance/deductions', [MaintenanceController::class, 'deductionRates'])->name('maintenance.deductions');

	Route::get('/transaction/release_entry', [TransactionController::class, 'releaseEntry'])->name('transaction.release_entry');
	Route::get('/transaction/override_release', [TransactionController::class, 'overrideRelease'])->name('transaction.override_release');
	Route::get('/transaction/rejected_release', [TransactionController::class, 'rejectedRelease'])->name('transaction.rejected_release');
	Route::get('/transaction/rejected_release/edit/{id}', [TransactionController::class, 'rejectedReleaseEdit'])->name('transaction.rejected_release.edit');
	Route::get('/transaction/repayment_entry', [TransactionController::class, 'repaymentEntry'])->name('transaction.repayment_entry');
	Route::get('/transaction/override_payment', [TransactionController::class, 'overridePayment'])->name('transaction.override_payment');
	Route::get('/transaction/overridepaymentdates', [TransactionController::class, 'overridePaymentDates']);
	Route::get('/transaction/release_entry/loanaccounts', [TransactionController::class, 'releaseAccounts']);
	Route::get('/transaction/todaysrelease', [TransactionController::class, 'todaysRelease']);
	Route::post('/transaction/payments/open', [TransactionController::class, 'openPayments']);
	Route::post('/transaction/payments/paidtoday', [TransactionController::class, 'paidTodayPayments']);

	Route::get('/reports/transaction/product', [ReportsController::class, 'transactionProduct'])->name('reports.transaction');
	Route::get('/reports/release/summary', [ReportsController::class, 'releaseSummary'])->name('reports.release.summary');
	Route::get('/reports/release/product', [ReportsController::class, 'releaseProduct'])->name('reports.release.product');
	Route::get('/reports/release/client', [ReportsController::class, 'releaseClient'])->name('reports.release.client');
	Route::get('/reports/release/ao', [ReportsController::class, 'releaseAo'])->name('reports.release.ao');
	Route::get('/reports/release/insurance', [ReportsController::class, 'releaseInsurance'])->name('reports.release.insurance');

	Route::get('/reports/repayment/product', [ReportsController::class, 'repaymentProduct'])->name('reports.repayment.product');
	Route::get('/reports/repayment/client', [ReportsController::class, 'repaymentClient'])->name('reports.repayment.client');
	Route::get('/reports/repayment/cancelled', [ReportsController::class, 'repaymentCancelled'])->name('reports.repayment.cancelled');

	Route::get('/reports/collection/product', [ReportsController::class, 'collectionProduct'])->name('reports.collection.product');
	Route::get('/reports/collection/client', [ReportsController::class, 'collectionClient'])->name('reports.collection.client');
	Route::get('/reports/collection/ao', [ReportsController::class, 'collectionAo'])->name('reports.collection.ao');

	Route::get('/reports/branch/collection_report', [ReportsController::class, 'branchCollectionReport'])->name('reports.branch.collection');
	Route::get('/reports/branch/maturity_report', [ReportsController::class, 'branchMaturityReport'])->name('reports.branch.maturity');
	Route::get('/reports/branch/client_payment_status', [ReportsController::class, 'branchPaymentStatus'])->name('reports.branch.paymentstatus');
	Route::get('/reports/branch/account_officer', [ReportsController::class, 'branchAccountOfficer'])->name('reports.branch.accountofficer');
	Route::get('/reports/branch/loan_listing', [ReportsController::class, 'branchLoanListing'])->name('reports.branch.loanlisting');
	Route::get('/reports/branch/loan_status_summary', [ReportsController::class, 'branchLoanStatusSummary'])->name('reports.branch.loanstatussummary');
	Route::get('/reports/branch/loan_aging_summary', [ReportsController::class, 'branchLoanAgingSummary'])->name('reports.branch.loanagingsummary');
	Route::get('/reports/branch/revenue_report', [ReportsController::class, 'branchRevenueReport'])->name('reports.branch.revenuereport');

	Route::get('/reports/consolidated/loan_summary_report', [ReportsController::class, 'consolidatedLoanSummaryReport'])->name('reports.consolidated.loansummaryreport');
	Route::get('/reports/consolidated/loan_aging_report', [ReportsController::class, 'consolidatedLoanAgingReport'])->name('reports.consolidated.loanagingreport');
	Route::get('/reports/consolidated/loan_performance_report', [ReportsController::class, 'consolidatedLoanPerformanceReport'])->name('reports.consolidated.loanperformancereport');

	Route::get('/reports/micro_monitoring', [ReportsController::class, 'reportsMicroMonitoring'])->name('reports.micromonitoring');
	Route::get('/reports/prepaid_interest', [ReportsController::class, 'reportsPrepaidInterest'])->name('reports.prepaidinterest');
	Route::get('/reports/performance_report', [ReportsController::class, 'reportsPerformanceReport'])->name('reports.performancereport');
	Route::get('/reports/bir', [ReportsController::class, 'birReport'])->name('reports.bir');



	Route::get('/endofday/', [EndOfDayController::class, 'index'])->name('endofday');
	Route::get('/eod/check', [EndOfDayController::class, 'eodCheck']);

});



