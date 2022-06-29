<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserBranch;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Users as UserResource;

class UserController extends BaseController
{
     /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'Users fetched.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->save();

        $branches = $request->input('branch');

        if( is_array($branches) && count($branches) > 0 ){

            foreach ($branches as $branch) {

                 UserBranch::create([
                    'user_id' => $user->id,
                    'branch_id' => $branch['branch_id'],
                ]);

            }

        }

        // user accessibility
        $permissions = $request->input('permissions');

        if( is_array($permissions) && count($permissions) > 0 ){

            foreach ($permissions as $permission) {
                
                UserAccessibility::create([
                    'id' => $user->id,
                    'access_id' => $permission,
                ]);
            }

        }
        return $this->sendResponse(new UserResource($user), 'User Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) {
        return $this->sendResponse(new UserResource($user), 'User fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch) {
        // return view()
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {

        // $input = $request->all();
        // # add validator na pd dri
        // $user->username = $request->input('username');
        // $user->password = Hash::make($request->input('password'));
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->status = $request->input('status');
        $user->update();
        // $branch->branch_code = isset($input['branch_code']) ? $input['branch_code'] : $branch->branch_code;
        // $branch->branch_name = isset($input['branch_name']) ? $input['branch_name'] : $branch->branch_name;
        // $branch->branch_address = isset($input['branch_address']) ? $input['branch_address'] : $branch->branch_address;
        // $branch->status = isset($input['status']) ? $input['status'] : $branch->status;
        // $branch->deleted = isset($input['deleted']) ? $input['deleted'] : $branch->deleted;
        // $branch->save(); 

        return $this->sendResponse(new UserResource($user), 'User Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}


}
