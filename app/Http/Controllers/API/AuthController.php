<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Borrower;
use App\Models\User;
use App\Models\Branch;
use App\Http\Resources\Users as UserResource;
use App\Http\Resources\Borrower as BorrowerResource;


class AuthController extends BaseController
{

    public function loginForm() {}

    public function login(Request $request) {

    	$credentials = $request->only('username', 'password');
        $branch_id = $request->branch_id;
    	if(Auth::attempt($credentials)){

            $isAllowed = false;
            if(Auth::user()->status === 'active'){
                foreach (Auth::user()->branch as $branch) {

                    if( $branch->branch_id == $branch_id ){
                        $isAllowed = true;
                        $request->session()->put('currentBranch', $branch_id);
                        break;
                    }
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

        return $this->sendError('Invalid Credentials / Cannot access specified branch', ['error' => 'Unauthorised'], 200);

    }

    public function borrowerLogin(Request $request) {
    	$credentials = $request->only('username', 'password');
		$user = Borrower::where('username', $request->credentials['username'])->first();
		$credentials = ['username'=>$request->credentials['username'], 'password'=>$request->credentials['password']];
    	if(Auth::guard('borrowers')->attempt($credentials)){
            $success['token'] =  Auth::guard('borrowers')->user()->createToken('auth_token')->plainTextToken;
            $success['name'] =  Auth::guard('borrowers')->user()->username;
            return $this->sendResponse($success, 'User signed in');
        }
        return $this->sendError('Invalid Credentials', ['error' => 'Unauthorised'], 200);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logout'
        ];
    }

}