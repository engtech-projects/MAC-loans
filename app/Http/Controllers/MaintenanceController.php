<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;

class MaintenanceController extends Controller
{
    public function productSetup(){
		return view('maintenance.product_setup')->with([
			'nav' => ['maintenance', 'product setup'],
			'title' => 'Product Setup',
		]);
	}

	public function cancelPayments(){
		return view('maintenance.cancel_payments')->with([
			'nav' => ['maintenance', 'cancel payments'],
			'title' => 'Cancel Payments',
		]);
	}

	public function centerAo(){
		return view('maintenance.center_ao')->with([
			'nav' => ['maintenance', 'center ao'],
			'title' => 'Center - Account Officer Setup',
		]);
	}

	public function userSettings(){
		return view('maintenance.user_settings')->with([
			'nav' => ['maintenance', 'user settings'],
			'title' => 'User Settings',
		]);
	}

	public function glSetup(){
		return view('maintenance.gl_setup')->with([
			'nav' => ['maintenance', 'gl setup'],
			'title' => 'General Ledger Setup',
		]);
	}

	public function accountRetagging(){
		return view('maintenance.account_retagging')->with([
			'nav' => ['maintenance', 'account retagging'],
			'title' => 'Account Retagging',
		]);
	}

	public function deductionRates(){
		return view('maintenance.deductions')->with([
			'nav' => ['maintenance', 'deduction rates'],
			'title' => 'Deduction Rate',
		]);
	}
}
