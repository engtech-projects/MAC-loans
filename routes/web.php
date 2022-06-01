<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductSetupController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ClientInformationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportsController;
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

Route::get('/', function () {
    return redirect('/dashboard');
});
Route::group(['middleware' => 'auth'], function (){
	Route::get('logout', [LoginController::class, 'logout']);
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/client_information/personal_information_list', [ClientInformationController::class, 'personalInformationList'])->name('client_information.personal_information_list');
	Route::get('/client_information/personal_information_details/{id}', [ClientInformationController::class, 'personalInformationDetails'])->name('client_information.personal_information_details');
	Route::get('/client_information/statement_of_accounts_list', [ClientInformationController::class, 'statementOfAccountsList'])->name('client_information.statement_of_accounts_list');
	
	Route::get('/maintenance/cancel_payments', [MaintenanceController::class, 'cancelPayments'])->name('maintenance.cancel_payments');
	Route::get('/maintenance/product_setup', [MaintenanceController::class, 'productSetup'])->name('maintenance.product_setup');
	Route::get('/maintenance/center_ao', [MaintenanceController::class, 'centerAo'])->name('maintenance.center_ao');
	Route::get('/maintenance/user_settings', [MaintenanceController::class, 'userSettings'])->name('maintenance.user_settings');
	Route::get('/maintenance/gl_setup', [MaintenanceController::class, 'glSetup'])->name('maintenance.gl_setup');
	Route::get('/maintenance/account_retagging', [MaintenanceController::class, 'accountRetagging'])->name('maintenance.account_retagging');


	Route::get('/maintenance/release_entry', [TransactionController::class, 'releaseEntry'])->name('transaction.release_entry');
	Route::get('/maintenance/override_release', [TransactionController::class, 'overrideRelease'])->name('transaction.override_release');
	Route::get('/transaction/rejected_release', [TransactionController::class, 'rejectedRelease'])->name('transaction.rejected_release');
	Route::get('/transaction/rejected_release/edit/{id}', [TransactionController::class, 'rejectedReleaseEdit'])->name('transaction.rejected_release.edit');
	Route::get('/transaction/repayment_entry', [TransactionController::class, 'repaymentEntry'])->name('transaction.repayment_entry');

	Route::get('/reports/transaction/product', [ReportsController::class, 'transactionProduct'])->name('reports.transaction');
	Route::get('/reports/release/product', [ReportsController::class, 'releaseProduct'])->name('reports.release.product');
	Route::get('/reports/release/client', [ReportsController::class, 'releaseClient'])->name('reports.release.client');
	Route::get('/reports/release/ao', [ReportsController::class, 'releaseAo'])->name('reports.release.ao');

	Route::get('/reports/repayment/product', [ReportsController::class, 'repaymentProduct'])->name('reports.repayment.product');
	Route::get('/reports/repayment/client', [ReportsController::class, 'repaymentClient'])->name('reports.repayment.client');

	Route::get('/reports/collection/product', [ReportsController::class, 'collectionProduct'])->name('reports.collection.product');
	Route::get('/reports/collection/client', [ReportsController::class, 'collectionClient'])->name('reports.collection.client');
	Route::get('/reports/collection/ao', [ReportsController::class, 'collectionAo'])->name('reports.collection.ao');

	Route::get('/transaction/release_entry', [TransactionController::class, 'releaseEntry'])->name('transaction.release_entry');
	Route::get('/transaction/override_release', [TransactionController::class, 'overrideRelease'])->name('transaction.override_release');
	Route::get('/transaction/rejected_release', [TransactionController::class, 'rejectedRelease'])->name('transaction.rejected_release');
	Route::get('/transaction/rejected_release/edit/{id}', [TransactionController::class, 'rejectedReleaseEdit'])->name('transaction.rejected_release.edit');

});



