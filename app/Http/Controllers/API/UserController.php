<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\UserAccessibility;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Users as UserResource;
use App\Models\Branch;
use Spatie\Activitylog\Models\Activity;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where(['deleted' => 0])->get();
        return $this->sendResponse(UserResource::collection($users), 'Users fetched.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->save();

        $branches = $request->input('branch');

        if (is_array($branches) && count($branches) > 0) {

            foreach ($branches as $branch) {

                $userBranch = UserBranch::create([
                    'id' => $user->id,
                    'branch_id' => $branch['branch_id'],
                ]);
            }
        }

        // user accessibility
        $permissions = $request->input('permissions');

        if (is_array($permissions) && count($permissions) > 0) {

            foreach ($permissions as $permission) {

                $userAccess = UserAccessibility::create([
                    'id' => $user->id,
                    'access_id' => $permission,
                ]);
            }
        }

        activity("User Settings")->event("created")->performedOn($user)
            ->withProperties(['model_snapshot' => $user->toArray()])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = null;
            })
            ->log("User - Create");
        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->sendResponse(new UserResource($user), 'User fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        // return view()
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $replicate = $user->replicate();
        $originalBranches = UserBranch::where('id', $user->id)->pluck('branch_id')->toArray();
        $originalPermissions = UserAccessibility::where('id', $user->id)->pluck('access_id')->toArray();
        $user->username = ($request->input('username') != null) ? $request->input('username') : $user->username;
        $user->password = ($request->input('password') != null) ? Hash::make($request->input('password')) : $user->password;
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->status = ($request->input('status') != null) ? $request->input('status') : $user->status;
        $user->deleted = ($request->input('deleted') != null) ? $request->input('deleted') : $user->deleted;
        $user->update();


        $branches = $request->input('branch');
        $permissions = $request->input('permissions');
        $newBranches = [];
        $newPermissions = [];

        if (is_array($branches) && count($branches) > 0) {
            UserBranch::where(['id' => $user->id])->delete();
            foreach ($branches as $branch) {
                $userBranch = UserBranch::create([
                    'id' => $user->id,
                    'branch_id' => $branch['branch_id'],
                ]);
            }
            $newBranches = collect($branches)->pluck('branch_id')->toArray();
        }

        if (is_array($permissions) && count($permissions) > 0) {

            UserAccessibility::where(['id' => $user->id])->delete();

            foreach ($permissions as $permission) {

                $userAccess = UserAccessibility::create([
                    'id' => $user->id,
                    'access_id' => $permission,
                ]);
            }
            $newPermissions = $permissions;
        }

        $changes = $this->getChanges($user, $replicate);
        if ($originalBranches !== $newBranches) {
            $changes['attributes']['branches'] = $newBranches;
            $changes['old']['branches'] = $originalBranches;
        }
        if ($originalPermissions !== $newPermissions) {
            $changes['attributes']['permissions'] = $newPermissions;
            $changes['old']['permissions'] = $originalPermissions;
        }
        if (!empty($changes['attributes'])) {
            unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
            activity("User Settings")->event("updated")->performedOn($user)
                ->withProperties([
                    'model_snapshot' => $user->toArray(),
                    'attributes' => $changes['attributes'],
                    'old' => $changes['old']
                ])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
                ->log("User - Update");
        }

        $user = User::find($user->id);
        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            UserBranch::where('id', $user->id)->delete();
            UserAccessibility::where('id', $user->id)->delete();
            $userData = $user->toArray();
            $user->delete();

            activity("User Settings")->event("deleted")->performedOn($user)
                ->withProperties([
                    'model_snapshot' => $userData,
                    'old' => $userData
                ])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
            ->log("User - Delete");
            return $this->sendResponse([], 'User deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error deleting user.', ['error' => $e->getMessage()]);
        }
    }
}
