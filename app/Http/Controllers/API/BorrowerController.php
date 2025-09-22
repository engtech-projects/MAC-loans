<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Carbon\Carbon;
use Storage;
use File;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\EmploymentInfo;
use App\Models\BusinessInfo;
use App\Models\HouseholdMembers;
use App\Models\OutstandingObligations;
use App\Models\LoanAccount;
use App\Http\Resources\Borrower as BorrowerResource;
use App\Http\Resources\BorrowerAccountsResource;
use Spatie\Activitylog\Contracts\Activity;

class BorrowerController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $borrowers = Borrower::all();
        return $this->sendResponse(BorrowerResource::collection($borrowers), 'Borrowers');
    }

    public function borrowerList($branchId, Request $request)
    {

        $branch = Branch::find($branchId);

        $borrowers = Borrower::join(
            'loan_accounts',
            'loan_accounts.borrower_id',
            '=',
            'borrower_info.borrower_id'
        )->join('product', 'loan_accounts.product_id', '=', 'product.product_id')
            ->select(
                'borrower_info.borrower_id',
                'borrower_info.borrower_num',
                'borrower_info.date_registered',
                'borrower_info.firstname',
                'borrower_info.middlename',
                'borrower_info.lastname',
                'borrower_info.suffix',
                'borrower_info.address',
                'borrower_info.birthdate',
                'borrower_info.gender',
                'borrower_info.status',
                'borrower_info.contact_number',
                'borrower_info.id_type',
                'borrower_info.id_no',
                'borrower_info.id_date_issued',
                'borrower_info.spouse_firstname',
                'borrower_info.spouse_middlename',
                'borrower_info.spouse_lastname',
                'borrower_info.spouse_address',
                'borrower_info.spouse_birthdate',
                'borrower_info.spouse_contact_number',
                'borrower_info.spouse_id_type',
                'borrower_info.spouse_id_no',
                'borrower_info.spouse_id_date_issued',

            )
            ->selectRaw('TIMESTAMPDIFF(YEAR, borrower_info.birthdate, CURDATE()) AS age')
            ->where(['loan_accounts.branch_code' => $branch->branch_code]);


        if (isset($request->onlyUnpaid)) {
            $borrowers = $borrowers->where('loan_accounts.loan_status', '!=', LoanAccount::PAYMENT_PAID)->distinct()->get();
        } else {
            $borrowers = $borrowers->distinct()->get();
        }



        return $this->sendResponse($borrowers, 'Borrowers');
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
        $borrower = new Borrower();
        // add borrower_num to request data
        $request->merge(['borrower_num' => '']);
        // create borrower
        $borrower = Borrower::create($request->input());
        $borrower->borrower_num = $borrower->generateBorrowerNum();
        $borrower->save();
        // upload image goes here.. .

        if ($request->hasFile('img')) {
            $borrower->setBorrowerPhoto($request->file('img'), false);
        }

        if (isset($request->img) && $request->img) {
            $borrower->setBorrowerPhoto($request->img);
        }

        // add other details
        $borrower->employmentInfo = $request->input('employmentInfo');
        $borrower->businessInfo = $request->input('businessInfo');
        $borrower->householdMembers = $request->input('householdMembers');
        $borrower->outstandingObligations = $request->input('outstandingObligations');

        if ($borrower->borrower_id) {

            if (count($borrower->employmentInfo)) {
                foreach ($borrower->employmentInfo as $key => $value) {
                    $borrower->employmentInfo()->save(new EmploymentInfo($value));
                }
            }

            if (count($borrower->businessInfo)) {
                foreach ($borrower->businessInfo as $key => $value) {
                    $borrower->businessInfo()->save(new BusinessInfo($value));
                }
            }

            if (count($borrower->householdMembers)) {
                foreach ($borrower->householdMembers as $key => $value) {
                    $borrower->householdMembers()->save(new HouseholdMembers($value));
                }
            }

            if (count($borrower->outstandingObligations)) {
                foreach ($borrower->outstandingObligations as $key => $value) {
                    $borrower->outstandingObligations()->save(new OutstandingObligations($value));
                }
            }
            activity("Release Entry")->event("updated")->performedOn($borrower)
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = now();
                })
                ->log("Borrower - Create");
            # add validator dri
            return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Created');
        }

        return $this->sendError('Error!', ['error' => 'Something went wrong']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrower $borrower)
    {
        return $this->sendResponse(new BorrowerResource($borrower), 'Borrower fetched.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrower $borrower)
    {
        $replicate = $borrower->replicate();
        $borrower->fill($request->input());
        $borrower->save();

        if ($request->hasFile('img')) {
            $borrower->setBorrowerPhoto($request->file('img'), false);
        }

        if (isset($request->img)) {
            $borrower->setBorrowerPhoto($request->img);
        }

        if ($request->hasFile('files')) {
            $borrower->setDocs($request->file('files'));
        }

        $borrower->employmentInfo = $request->input('employmentInfo');
        $borrower->businessInfo = $request->input('businessInfo');
        $borrower->householdMembers = $request->input('householdMembers');
        $borrower->outstandingObligations = $request->input('outstandingObligations');

        if (count($borrower->employmentInfo)) {
            EmploymentInfo::upsert(
                $borrower->employmentInfo,
                ['id'],
                ['company_name', 'company_address', 'contact_no', 'years_employed', 'position', 'salary'],
            );
        }

        if (count($borrower->businessInfo)) {
            BusinessInfo::upsert(
                $borrower->businessInfo,
                ['id'],
                ['business_name', 'business_type', 'business_address', 'contact_no', 'years_in_business', 'income'],
            );
        }

        if (count($borrower->householdMembers)) {
            HouseholdMembers::upsert(
                $borrower->householdMembers,
                ['id'],
                ['dependent', 'age', 'relationship', 'occupation', 'contact_no', 'sbe_address'],
            );
        }

        if (count($borrower->outstandingObligations)) {
            OutstandingObligations::upsert(
                $borrower->outstandingObligations,
                ['id'],
                ['creditor', 'amount', 'balance', 'term', 'due_date', 'amortization'],
            );
        }
        activity("Maintenance")->event("updated")->performedOn($borrower)
            ->withProperties(['attributes' => $borrower, 'old' => $replicate])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = now();
            })
            ->log("Borrower - Update");

        return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Updated.');
    }
}
