<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Branch;
use App\Http\Resources\Users as UserResource;


class AuthController extends BaseController
{

    public function loginForm() {}

    public function login(Request $request) {
    	
    	$credentials = $request->only('username', 'password');
        $branch_id = $request->branch_id;

    	if(Auth::attempt($credentials)){

            $isAllowed = false;

            foreach (Auth::user()->branch as $branch) {
                
                if( $branch->branch_id == $branch_id ){
                    $isAllowed = true;
                    break;
                }
            }

            if( $isAllowed ) {
                $success['token'] =  Auth::user()->createToken('auth_token')->plainTextToken;
                $success['name'] =  Auth::user()->username;
                $success['branch'] = $branch_id;
                // $success['tokens'] = Auth::user()->tokens;
                return $this->sendResponse($success, 'User signed in');
            }
        }
        
        return $this->sendError('Invalid Credentials / Cannot access specified branch', ['error' => 'Unauthorised']);
        
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logout'
        ];
    }

}