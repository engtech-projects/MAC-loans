<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Borrower;
use Session;

class BorrowerLoginController extends Controller
{
    public function login(Request $request){
		// echo $request;
		$user = Borrower::where('username', $request->credentials['username'])->first();
		$credentials = ['username'=>$request->credentials['username'], 'password'=>$request->credentials['password']];
		if(Auth::guard("borrowers")->attempt($credentials)) {
			Auth::guard("borrowers")->user()->token = $request->token;
			Session::put("id", $user->borrower_id);
			Session::put('token', $request->token);
			Session::put('fullname', $user->firstname.' '.$user->middlename.' '.$user->lastname);
			return Auth::guard("borrowers")->user();
		}
	}

	public function index(){
		return view('auth.borrower_login');
	}

	public function logout(){
		Auth::logout();
 		return redirect('/borrower_login');
	}
}
