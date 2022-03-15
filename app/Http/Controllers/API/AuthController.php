<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{

    public function loginForm() {}

    public function login(Request $request) {
    	
    	$credentials = $request->only('username', 'password', 'branch_id');

    	if(Auth::attempt($credentials)){ 

            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('auth_token')->plainTextToken;
            $success['name'] =  $authUser->username;
            
            return $this->sendResponse($success, 'User signed in');
            
        } 
        else{ 
            return $this->sendError('Error.', ['error'=>'Unauthorised']);
        } 
    }

    public function logout() {

    }

}
