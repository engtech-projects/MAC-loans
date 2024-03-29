<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\Models\Borrower;

class ClientInformationController extends Controller
{
	
    public function personalInformationList(){
		$this->checkAccess('view borrower');
		return view('client_information.personal_information_list')->with([
			'nav' => ['client information', 'personal information list'],
			'title' => 'MAC | Personal Information List',
		]);
	}

	public function personalInformationDetails($id){
		$this->checkAccess('view borrower');
		return view('client_information.personal_information_details')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => $id,
			'title' => 'MAC | Personal Information',
		]);
	}

	public function statementOfAccountsList(){
		$this->checkAccess('view statement of accounts');
		return view('client_information.statement_of_accounts_list')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'title' => 'MAC | Statement of Account List',
		]);
	}

	public function personalInformationDetailsEdit($id){
		$this->checkAccess('edit borrower');
		return view('client_information.personal_information_details_edit')->with([
			'nav' => ['client information', 'personal information list'],
			'id' => $id,
			'title' => 'MAC | Edit Personal Information',
		]);
	}

	public function accountStatementDetails($id){
		$this->checkAccess('view statement of accounts');
		return view('client_information.account_statement_details')->with([
			'nav' => ['client information', 'statement of accounts list'],
			'id' => $id,
			'title' => 'MAC | Statement of Account Details',
		]);
	}
	public function balanceInquiry($id){
		$this->checkAccess('view balance inquiry');
		return view('client_information.balance_inquiry')->with([
			'nav' => ['client information', 'balance inquiry'],
			'title' => 'MAC | Balance Inquiry',
			'id' => $id
		]);
	}

	public function balanceInquiryList(){
		$this->checkAccess('view balance inquiry');
		return view('client_information.balance_inquiry_list')->with([
			'nav' => ['client information', 'balance inquiry'],
			'title' => 'MAC | Balance Inquiry Loan Account List',
		]);
	}
	
	public function statement($id){
		return \App\Models\LoanAccount::where('account_num', $id)->first();
	}

	public function deleteOtherInfo(Request $request){
		if($request->type == 'householdMembers'){
			return \App\Models\HouseholdMembers::find($request->id)->delete();
		}
		if($request->type == 'outstandingObligations'){
			return \App\Models\OutstandingObligations::find($request->id)->delete();
		}
		if($request->type == 'employmentInfo'){
			return \App\Models\EmploymentInfo::find($request->id)->delete();
		}
		if($request->type == 'businessInfo'){
			return \App\Models\BusinessInfo::find($request->id)->delete();
		}
		return 0;
	}

}
