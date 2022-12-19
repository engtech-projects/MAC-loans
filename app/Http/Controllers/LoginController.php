<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
	
	public $intCounts = ["test"=> 1];
	public $prinCounts = ["test"=> 1];
	

    public function login(Request $request){
		$user = User::where('username', $request->credentials['username'])->first();
		$credentials = ['username'=>$request->credentials['username'], 'password'=>$request->credentials['password']];
		if(Auth::attempt($credentials)) {
			Auth::user()->token = $request->token;
			Session::put('token', $request->token);
			return Auth::user();
		}
	}

	public function index(){
		return view('auth.login');
	}

	public function logout(){
		Auth::logout();
 		return redirect('/login');
	}

	public function loadDB(){
		ini_set('max_execution_time', 0);
		$table = 'payment';
		$csvUrl = "C:\Users\Engtech PC 1\Desktop\MAC Database\CSV\payment_5.csv";
		$index = 5;
		$path = dirname(__FILE__)."/$table";
		$splitSize = "50000";
		// 1. download
		// 2. split
		echo '<br /> Download and Split data.. .'.'<br />';
		$this->SplitToCSV($csvUrl, $path, $splitSize, true, $index);
		echo '<br/>';
		echo $csvUrl . '<br /> was succesfully split in parts of ' .$splitSize . ' records. <br/> Destination: ' . dirname(__FILE__).'/';
		// 3. import 
		echo '<br /> Importing Data.. .'.'<br />';
		$this->prepareImport($table, $index);
		echo '<br /> Done.. .'.'<br />';
		// 4. run stored procedure
	}
	// download and split
	function SplitToCSV($csvPath, $outputPath, $splitSize, $keepHeaders = true, $currentFile = 1) {
	
		$currentRow = 0;
	
		$fh = fopen($csvPath, 'r');
		if ($keepHeaders) {
			$headers = fgetcsv($fh);
		}
		
		
		while (!feof($fh)) {
			if ($currentRow % $splitSize == 0) {
				if ($currentRow > 0) {
					fclose($outputFile);
				}
				$filename = $outputPath . "_" . $currentFile++ . ".csv";
				$outputFile = fopen($filename, 'w');
				echo '<br/> File: '.$filename.'<br/>';
				if ($keepHeaders) {
					fputcsv($outputFile, $headers);
				}
			}
			if ($row = fgetcsv($fh)) {
				fputcsv($outputFile, $row);
			}
			++$currentRow;
		}
		fclose($fh);
	}
	
	function prepareImport($table, $index) {
	
		if($index == 1) {
			//Delete table content
			DB::statement("TRUNCATE TABLE $table");
		}
	
		$filename = dirname(__FILE__)."/${table}_${index}.csv";
	
		if( file_exists($filename) ){
			$this->importDataToTable($filename, $table);
			$this->prepareImport($table, $index+1);
		}
		return;
	}
	
	function importDataToTable($csvUrl, $table) {
	
	
		$csvFile = fopen($csvUrl, 'r');
	
		$headers = fgetcsv($csvFile);
		//echo $table . "<br>";
		
		// Parse data from CSV file line by line
		$result = true;
		while (($line = fgetcsv($csvFile, 0, ',')) !== false) {
			// Get row data
			// var_export($line);
			$result = $this->processPaymentLineData($table, $line);
		}
		
		if($result) {
			return "Processed $csvUrl <br>";
		}
		else {
			return "Processed $csvUrl FAILED!! <br>";
		}
	
		
	}
	
	
	function processBorrowerLineData($table, $line){
	
	
		$ID = $line[0];
	
		$key = "borrower_id";
		$columns = [
			"borrower_id" => '',
			"borrower_num" => '',
			"date_registered" => '',
			"firstname" => '',
			"middlename" => '',
			"lastname" => '',
			"suffix" => '',
			"address" => '',
			"birthdate" => '',
			"gender" => '',
			"status" => '',
			"contact_number" => '',
			"id_type" => '',
			"id_no" => '',
			"id_date_issued" => '',
			"spouse_firstname" => '',
			"spouse_middlename" => '',
			"spouse_lastname" => '',
			"spouse_address" => '',
			"spouse_birthdate" => '',
			"spouse_contact_number" => '',
			"spouse_id_type" => '',
			"spouse_id_no" => '',
			"spouse_id_date_issued" => '',
			"created_at" => '',
			"updated_at" => '',
		];
		$data = [
			"suffix"=>"",
			'contact_number'=>"n/a",
			'id_type' => 'n/a',
			'id_no' => 'n/a',
			'address' => 'n/a',
			'middlename' => 'n/a',
			'id_date_issued' => 'n/a',
		];
	
		if($ID > 0) {
			foreach($columns as $k => $v) {
				if($line[$v] != ""){
					$data[$k] = $line[$v];
				}
			}
			DB::table($table)->upsert($data,["borrower_num"]);
		}
	
		return true;
	
	}
	function processLoanAccountLineData($table, $line){
	
	
		$ID = $line[0];
	
		$key = "loan_account_id";
		$columns = [
			// "loan_account_id" => '',
			"account_num" => '0',
			"date_release" => '9',
			"transaction_date" => '78',
			"cycle_no" => '41',
			"ao_id" => '49',
			"product_id" => '90',
			"center_id" => '39',
			"type" => '94',
			"payment_mode" => '50',
			"terms" => '8',
			"loan_amount" => '7',
			"interest_rate" => '31',
			"interest_amount" => '27',
			"no_of_installment" => '51',
			"due_date" => '10',
			"day_schedule" => '69',
			"borrower_num" => '1',
			"borrower_id" => '1',
			"co_borrower_name" => '59',
			"co_borrower_address" => '60',
			"co_borrower_id_type" => '61',
			"co_borrower_id_number" => '62',
			"co_borrower_id_date_issued" => '63',
			"co_maker_name" => '64',
			"co_maker_address" => '65',
			"co_maker_id_type" => '66',
			"co_maker_id_number" => '67',
			"co_maker_id_date_issued" => '68',
			"document_stamp" => '23',
			"filing_fee" => '15',
			"insurance" => '16',
			"notarial_fee" => '17',
			"prepaid_interest" => '18',
			"affidavit_fee" => '19',
			"memo" => '20',
			// "total_deduction" => '',
			// "net_proceeds" => '',
			"release_type" => '85',
			// "status" => '',
			"branch_code" => '88',
			"created_at" => '78',
			// "updated_at" => '',
		];
		$data = [
			// "suffix"=>"",
			'co_maker_id_date_issued' => "n/a",
			'co_maker_id_number' => 'n/a',
			'co_maker_id_type' => 'n/a',
			"co_borrower_name" => "n/a",
			"co_borrower_address" => "n/a",
			'co_borrower_id_date_issued' => 'n/a',
			'co_borrower_id_number' => 'n/a',
			'co_borrower_id_type' => 'n/a',
			"status" => "released",
			"co_maker_name" => "n/a",
			"type" => "n/a",
		];
		$daySched = [
			0 => "Daily",
			1 => "Daily",
			2 => "Monday",
			3 => "Tuesday",
			4 => "Wednesday",
			5 => "Thursday",
			6 => "Friday",
		];
		$payMode = [
			0 => "Unknown",
			1 => "Daily",
			7 => "Weekly",
			15 => "Bi-Monthly",
			30 => "Monthly",
			90 => "Quarterly",
		];
		if($ID > 0) {
			foreach($columns as $k => $v) {
				if($k == "interest_rate"){
					if($line[$v] != ""){
						$data[$k] = $line[$v] / 12;
					}
				}else if($k == "product_id"){
					if($line[$v] == ""){
						$data[$k] = "1";
					}else{
						$data[$k] = $line[$v];
					}
				}else if($k == "branch_code"){
					if($line[$v] == ""){
						$data[$k] = "1";
					}else{
						$data[$k] = $line[$v];
					}
				}else if($k == "payment_mode"){
					if($line[$v] != ""){
						$data[$k] = $payMode[$line[$v]];
					}
				}else if($k == "day_schedule"){
					if($line[$v] != ""){
						$data[$k] = $daySched[$line[$v]];
					}
				}else if($k == "center_id"){
					if($line[$v] == ""){
						$data[$k] = "2";
					}else{
						$centerID = DB::table("centers")->where('center', $line[$v])->first();
						$data[$k] = $centerID->center_id;
					}
				}else{
					if($line[$v] != ""){
						$data[$k] = $line[$v];
					}
				}
			}
			DB::table($table)->upsert($data,["account_num"]);
		}
	
		return true;
	
	}
	function processAmortizationLineData($table, $line){
		$ID = $line[0];
	
		$key = "loan_account_id";
		$columns = [
			// "id" => '',
			"loan_account_id" => '0',
			"amortization_date" => '1',
			"principal" => '2',
			"interest" => '3',
			"total" => '0',
			"principal_balance" => '0',
			"interest_balance" => '0',
			"status" => '5',
			"trNo" => '10',
			"created_at" => '0',
			// "updated_at" => '',
		];
		$data = [
			// "suffix"=>"",
			// 'co_maker_id_date_issued' => "n/a",
			// 'co_maker_id_number' => 'n/a',
			// 'co_maker_id_type' => 'n/a',
			// "co_borrower_name" => "n/a",
			// "co_borrower_address" => "n/a",
			// 'co_borrower_id_date_issued' => 'n/a',
			// 'co_borrower_id_number' => 'n/a',
			// 'co_borrower_id_type' => 'n/a',
			// "status" => "released",
			// "co_maker_name" => "n/a",
			// "type" => "n/a",
		];
		if($ID > 0) {
			foreach($columns as $k => $v) {
				if($k == "status"){
					if($line[$v] != ""){
						$data[$k] = "paid";
					}else{
						$data[$k] = "pending";
					}
				}else if($k == "amortization_date"){
					if($line[$v] != ""){
						$data[$k] = $line[$v];
					}else{
						$data[$k] = $line[5];
					}
				}else if($k == "created_at"){
					$row = DB::table("loan_accounts")->where('account_num', $line[$v])->first();
					$data[$k] = $row->created_at;
				}else if($k == "total"){
					$data[$k] = $line[2] + $line[3];
				}else if($k == "principal_balance"){
					$row = DB::table("loan_accounts")->where('account_num', $line[$v])->first();
					$loanAmt = $row->loan_amount;
					if(array_key_exists($line[$v], $this->prinCounts)){
						$this->prinCounts[$line[$v]] += 1;
						$count =  $this->prinCounts[$line[$v]];
					}else{
						 $this->prinCounts[$line[$v]] = 1;
						$count =  $this->prinCounts[$line[$v]];
					}
					$data[$k] = $loanAmt - ($line[2] * $count);
				}else if($k == "interest_balance"){
					$row = DB::table("loan_accounts")->where('account_num', $line[$v])->first();
					$interestAmt = $row->interest_amount;
					if(array_key_exists($line[$v], $this->intCounts)){
						$this->intCounts[$line[$v]] += 1;
						$count = $this->intCounts[$line[$v]];
					}else{
						$this->intCounts[$line[$v]] = 1;
						$count = $this->intCounts[$line[$v]];
					}
					$data[$k] = $interestAmt - ($line[3] * $count);
				}else if($k == "loan_account_id"){
					$row = DB::table("loan_accounts")->where('account_num', $line[$v])->first();
					if($row){
						$data[$k] = $row->loan_account_id;
					}else{
						echo "LOAN ACCOUNT NOT FOUND ". $line[$v] ."<br>";
						return true;
					}
				}else{
					if($line[$v] != ""){
						$data[$k] = $line[$v];
					}
				}
			}
			var_dump($data);
			echo "<br>";
			DB::table($table)->upsert($data, ["loan_account_id", "amortization_date"], array_keys($data));
		}
	
		return true;
	
	}
	function processPaymentLineData($table, $line){
		$ID = $line[0];
	
		$key = "id";
		$columns = [
			// "id" => '',
			"loan_account_id" => '0',
			"branch_id" => '44',
			"payment_type" => '39',
			"or_no" => '14',
			"cheque_no" => '36',
			"bank_name" => '37',
			"reference_no" => '38',
			"memo_type" => '39',
			"amortization_id" => '17',
			"principal" => '4',
			"interest" => '5',
			// "short_principal" => '',
			// "advance_principal" => '',
			// "short_interest" => '',
			// "advance_interest" => '',
			// "pdi" => '',
			// "pdi_approval_no" => '',
			// "penalty" => '',
			// "penalty_approval_no" => '',
			// "rebates" => '',
			// "rebates_approval_no" => '',
			// "total_payable" => '',
			"amount_applied" => '0',
			"status" => '0',
			"created_at" => '35',
			// "updated_at" => '',
		];
		$data = [
		];
		$payTypes = [
			"CHK" => "Cheque",
			"CSH" => "Cash",
			"POS" => "POS",
			"MEM" => "Rebate / Discount",
			"MBP" => "Interbranch Payment",
			"MCP" => "Cancelled Payment",
			"MDB" => "Deduct to Balance",
			"MOP" => "Overpayment",
			"MPF" => "Offset PF",
			// "MEM" => "Memo",
			// "MBP" => "Memo",
			// "MCP" => "Memo",
			// "MDB" => "Memo",
			// "MOP" => "Memo",
			// "MPF" => "Memo",
		];
		$memoTypes = [
			"MEM" => "Rebate / Discount",
			"MBP" => "Interbranch Payment",
			"MCP" => "Cancelled Payment",
			"MDB" => "Deduct to Balance",
			"MOP" => "Overpayment",
			"MPF" => "Offset PF",
		];
		if($ID > 0) {
			foreach($columns as $k => $v) {
				if($k == "payment_type"){
					$data[$k] = $payTypes[$line[$v]];
					if($data[$k] == "Memo"){
						$data["memo_type"] = $MemoTypes[$line[$v]];
					}
				}else if($k == "loan_account_id"){
					$row = DB::table("loan_accounts")->where('account_num', $line[$v])->first();
					if($row){
						$data[$k] = $row->loan_account_id;
					}else{
						echo "LOAN ACCOUNT NOT FOUND ". $line[$v] ."<br>";
						return true;
					}
				}else if($k == "amortization_id"){
					if($line[$v] != ""){
						$row = DB::table("amortization")->where('trNo', $line[$v])->first();
						$data[$k] = $row ? $row->trNo : 0;
						$data["total_payable"] = $row ? $row->total : 0;
					}
				}else if($k == "amount_applied"){
					$data[$k] = $line[$columns["principal"]] +$line[$columns["interest"]];
				}else if($k == "status"){
					$data[$k] = "posted";
				}else{
					if($line[$v] != ""){
						$data[$k] = $line[$v];
					}
				}
			}
			var_dump($data);
			echo "<br>";

			// CHANGE TO updateOrCreate
			DB::table($table)->upsert($data, ["loan_account_id", "amortization_date"], array_keys($data));
		}
	
		return true;
	
	}
}
