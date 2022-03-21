<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Carbon\Carbon;
use App\Models\Borrower;
use App\Models\EmploymentInfo;
use App\Models\BusinessInfo;
use App\Models\HouseholdMembers;
use App\Models\OutstandingObligations;
use App\Models\LoanAccount;
use App\Http\Resources\Borrower as BorrowerResource;

class BorrowerController extends BaseController
{

	/**
     * Display a listing of the resource.
     */
    public function index() {

    	$borrowers = Borrower::all();
    	return $this->sendResponse(BorrowerResource::collection($borrowers), 'Borrowers');

    }
     /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $borrower = new Borrower();    
        // add borrower_num to request data
        $request->merge(['borrower_num' => $borrower->generateBorrowerNum() ]);
        // create borrower
        $borrower = Borrower::create($request->input());
        // add other details
        $borrower->employmentInfo = $request->input('employmentInfo');
        $borrower->businessInfo = $request->input('businessInfo');
        $borrower->householdMembers = $request->input('householdMembers');
        $borrower->outstandingObligations = $request->input('outstandingObligations');

        if( $borrower->borrower_id ){

            if( count($borrower->employmentInfo) ){
                foreach ($borrower->employmentInfo as $key => $value) {
                    $borrower->employmentInfo()->save(new EmploymentInfo($value));
                }    
            }

            if( count($borrower->businessInfo) ){
                foreach ($borrower->businessInfo as $key => $value) {
                    $borrower->businessInfo()->save(new BusinessInfo($value));
                }    
            }

            if( count($borrower->householdMembers) ){
                foreach ($borrower->householdMembers as $key => $value) {
                    $borrower->householdMembers()->save(new HouseholdMembers($value));
                }    
            }

            if( count($borrower->outstandingObligations) ){
                foreach ($borrower->outstandingObligations as $key => $value) {
                    $borrower->outstandingObligations()->save(new OutstandingObligations($value));
                }    
            }
            # add validator dri
            return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Created');
        }

        return $this->sendError('Error!', ['error' => 'Something went wrong']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrower $borrower) {
        return $this->sendResponse(new BorrowerResource($borrower), 'Borrower fetched.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrower $borrower) {

        $borrower->fill($request->input());
        $borrower->save();

        $borrower->employmentInfo = $request->input('employmentInfo');
        $borrower->businessInfo = $request->input('businessInfo');
        $borrower->householdMembers = $request->input('householdMembers');
        $borrower->outstandingObligations = $request->input('outstandingObligations');

        if( count($borrower->employmentInfo) ){
            EmploymentInfo::upsert(
                $borrower->employmentInfo, 
                ['id'],
                ['company_name','company_address','contact_no','years_employed','position','salary'],
            ); 
        }

        if( count($borrower->businessInfo) ) {
            BusinessInfo::upsert(
                $borrower->businessInfo,
                ['id'],
                ['business_name','business_type','business_address','contact_no','years_in_business','income'],
            );
        }

        if( count($borrower->householdMembers) ) {
            HouseholdMembers::upsert(
                $borrower->householdMembers,
                ['id'],
                ['dependent','age','relationship','occupation','contact_no','sbe_address'],
            );
        }

        if( count($borrower->outstandingObligations) ) {
            OutstandingObligations::upsert(
                $borrower->outstandingObligations,
                ['id'],
                ['creditor','amount','balance','term','due_date','amortization'],
            );
        }

        return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Updated.');
    }


}
