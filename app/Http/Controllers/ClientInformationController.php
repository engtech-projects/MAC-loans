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

	public function personalInformationDetails(){
		return view('client_information.personal_information_details')->with([
			'nav' => ['client information', 'personal information list'],
			'title' => 'Personal Information',
		]);
	}

	public function statementOfAccountsList(){
		return view('client_information.statement_of_accounts_list')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'title' => 'Statement of Account List',
		]);
	}
}
