<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function login(Request $request){
		$user = User::where('username', $request->credentials['username'])->first();
		if(Auth::attempt($request->credentials)) {
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
}
