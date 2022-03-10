<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductSetupController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ClientInformationController;
use App\Http\Controllers\LoginController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', function () {
    
});
Route::group(['middleware' => 'auth'], function (){
	Route::get('logout', [LoginController::class, 'logout']);
	Route::get('/client_information/personal_information_list', [ClientInformationController::class, 'personalInformationList'])->name('client_information.personal_information_list');
	Route::get('/client_information/personal_information_details', [ClientInformationController::class, 'personalInformationDetails'])->name('client_information.personal_information_details');
	Route::get('/client_information/statement_of_accounts_list', [ClientInformationController::class, 'statementOfAccountsList'])->name('client_information.statement_of_accounts_list');
	
	Route::get('/maintenance/cancel_payments', [MaintenanceController::class, 'cancelPayments'])->name('maintenance.cancel_payments');
	Route::get('/maintenance/product_setup', [MaintenanceController::class, 'productSetup'])->name('maintenance.product_setup');
	Route::get('/maintenance/center_ao', [MaintenanceController::class, 'centerAo'])->name('maintenance.center_ao');
	Route::get('/maintenance/user_settings', [MaintenanceController::class, 'userSettings'])->name('maintenance.user_settings');
	Route::get('/maintenance/gl_setup', [MaintenanceController::class, 'glSetup'])->name('maintenance.gl_setup');
	Route::get('/maintenance/account_retagging', [MaintenanceController::class, 'accountRetagging'])->name('maintenance.account_retagging');
});



