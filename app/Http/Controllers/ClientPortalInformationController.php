<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ClientPortalInformationController extends Controller
{
	
    public function personalInformationList(){
		return view('client_portal_information.personal_information_list')->with([
			'nav' => ['client information', 'personal information list'],
			'title' => 'Personal Information List',
		]);
	}

	public function personalInformationDetails(){
		return view('client_portal_information.personal_information_details')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => Session::get('id'),
			'title' => 'Personal Information',
		]);
	}

	public function statementOfAccountsList(){
		return view('client_portal_information.statement_of_accounts_list')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'title' => 'Statement of Account List',
		]);
	}

	public function personalInformationDetailsEdit(){
		return view('client_portal_information.personal_information_details_edit')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => Session::get('id'),
			'title' => 'Edit Personal Information',
		]);
	}

	public function accountStatementDetails(){
		return view('client_portal_information.account_statement_details')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'id' => Session::get('id'),
			'title' => 'Statement of Account Details',
		]);
	}
	
	public function statement(){
		return \App\Models\LoanAccount::where('account_num', Session::get('id'))->first();
	}

}
