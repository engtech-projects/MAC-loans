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

    public function checkDuplicate(Request $request)
    {
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $birthDate = $request->input('birthdate');
        $excludeId = $request->input('exclude_id');

        if (!$firstName || !$lastName || !$birthDate) {
            return $this->sendError('Missing required fields', ['error' => 'firstname, lastname, and birthdate are required'], 400);
        }

        $duplicateResponse = $this->checkDuplicateBorrower($firstName, $lastName, $birthDate, $excludeId, false);
        
        if ($duplicateResponse) {
            return $duplicateResponse;
        }

        return $this->sendResponse(null, 'No duplicate found');
    }

    private function checkDuplicateBorrower(string $firstName, string $lastName, string $birthDate, $excludeId = null, bool $bypassDuplicate = false)
    {
        if ($bypassDuplicate) {
            return null;
        }

        $query = Borrower::where('firstname', trim($firstName))
            ->where('lastname', trim($lastName))
            ->where('birthdate', $birthDate);

        if ($excludeId) {
            $query->where('borrower_id', '!=', $excludeId);
        }

        $exactMatch = $query->first();

        if ($exactMatch) {
            return $this->sendError('Duplicate borrower detected (exact match)', [
                'duplicate' => [
                    'borrower_id' => $exactMatch->borrower_id,
                    'firstname'   => $exactMatch->firstname,
                    'lastname'    => $exactMatch->lastname,
                    'birthdate'   => $exactMatch->birthdate,
                    'match_type'  => 'exact'
                ]
            ], 422);
        }

        $fuzzyMatch = Borrower::whereRaw("SOUNDEX(firstname) = SOUNDEX(?)", [$firstName])
            ->whereRaw("SOUNDEX(lastname) = SOUNDEX(?)", [$lastName])
            ->when($excludeId, fn($q) => $q->where('borrower_id', '!=', $excludeId))
            ->first();

        if ($fuzzyMatch) {
            return $this->sendError('Possible duplicate borrower detected (fuzzy match)', [
                'duplicate' => [
                    'borrower_id' => $fuzzyMatch->borrower_id,
                    'firstname'   => $fuzzyMatch->firstname,
                    'lastname'    => $fuzzyMatch->lastname,
                    'birthdate'   => $fuzzyMatch->birthdate,
                    'match_type'  => 'fuzzy'
                ]
            ], 422);
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $birthDate = $request->input('birthdate');
        $bypassDuplicate = $request->input('bypass_duplicate', false);
        if ($firstName && $lastName && $birthDate) {
            if ($response = $this->checkDuplicateBorrower($firstName, $lastName, $birthDate, null, $bypassDuplicate)) {
                return $response;
            }
        }
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
            activity("Release Entry")->event("created")->performedOn($borrower)
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = $this->transactionDate();
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
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $birthDate = $request->input('birthdate');
        $bypassDuplicate = $request->input('bypass_duplicate', false);
        if ($firstName && $lastName && $birthDate) {
            if ($response = $this->checkDuplicateBorrower($firstName, $lastName, $birthDate, $borrower->borrower_id, $bypassDuplicate)) {
                return $response;
            }
        }
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
        $changes = $this->getChanges($borrower, $replicate);
        activity("Maintenance")->event("updated")->performedOn($borrower)
            ->withProperties(['attributes' => $changes['attributes'], 'old' => $changes['old']])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = $this->transactionDate();
            })
            ->log("Borrower - Update");

        return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Updated.');
    }
}
