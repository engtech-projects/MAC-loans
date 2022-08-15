<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientInformationController extends Controller
{
	
    public function personalInformationList(){
		return view('client_information.personal_information_list')->with([
			'nav' => ['client information', 'personal information list'],
			'title' => 'Personal Information List',
		]);
	}

	public function personalInformationDetails($id){
		return view('client_information.personal_information_details')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => $id,
			'title' => 'Personal Information',
		]);
	}

	public function statementOfAccountsList(){
		return view('client_information.statement_of_accounts_list')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'title' => 'Statement of Account List',
		]);
	}

	public function personalInformationDetailsEdit($id){
		return view('client_information.personal_information_details_edit')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => $id,
			'title' => 'Edit Personal Information',
		]);
	}

	public function accountStatementDetails($id){
		return view('client_information.account_statement_details')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'id' => $id,
			'title' => 'Statement of Account Details',
		]);
	}
	
	public function statement($id){
		return \App\Models\LoanAccount::where('account_num', $id)->first();
	}

}
