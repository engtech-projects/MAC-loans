<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\AccountOfficer;
use App\Http\Resources\AccountOfficer as AccountOfficerResource;
use Spatie\Activitylog\Models\Activity;

class AccountOfficerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountOfficer = AccountOfficer::all();
        return $this->sendResponse(AccountOfficerResource::collection($accountOfficer), 'AO fetched.');
    }

    public function getActiveInBranch($branch_id)
    {
        $accountOfficer = AccountOfficer::join('account_officer_branch', 'account_officer.ao_id', '=', 'account_officer_branch.ao_id')
            ->join('branch', 'account_officer_branch.branch_id', '=', 'branch.branch_id')
            ->where([
                'account_officer.status' => AccountOfficer::STATUS_ACTIVE,
                'branch.branch_id' => $branch_id
            ])
            ->select('account_officer.*')
            ->orderBy('account_officer.name', 'ASC')
            ->groupBy('account_officer.ao_id')
            ->get();
        return $this->sendResponse(AccountOfficerResource::collection($accountOfficer), 'AO fetched.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $input = $request->all();
        # add validator dri
        $accountOfficer = AccountOfficer::create($input);
        activity("Center - AO Setup")->event("created")->performedOn($accountOfficer)
            ->withProperties(['model_snapshot' => $accountOfficer->toArray()])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = null;
            })
            ->log("Account Officer - Create");
        return $this->sendResponse(new AccountOfficerResource($accountOfficer), 'AO Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountOfficer $accountofficer)
    {
        return $this->sendResponse(new AccountOfficerResource($accountofficer), 'AO fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountOfficer $accountofficer)
    {
        // return view()
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountOfficer $accountofficer)
    {
        $input = $request->all();
        $replicate = $accountofficer->replicate();
        $accountofficer->name = isset($input['name']) ? $input['name'] : $accountofficer->name;
        $accountofficer->branch_id = isset($input['branch_id']) ? $input['branch_id'] : $accountofficer->branch_id;
        $accountofficer->status = isset($input['status']) ? $input['status'] : $accountofficer->status;
        $accountofficer->deleted = isset($input['deleted']) ? $input['deleted'] : $accountofficer->deleted;
        $accountofficer->save();
        $changes = $this->getChanges($accountofficer, $replicate);
        unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
        if (!empty($changes['attributes'])) {
            activity("Center - AO Setup")->event("updated")->performedOn($accountofficer)
                ->withProperties([
                    'model_snapshot' => $accountofficer->toArray(),
                    'attributes' => $changes['attributes'], 
                    'old' => $changes['old']
                ])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
                ->log("Account Officer - Update");
        }
        return $this->sendResponse(new AccountOfficerResource($accountofficer), 'AO Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}
