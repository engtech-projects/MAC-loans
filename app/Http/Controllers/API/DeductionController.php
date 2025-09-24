<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Deduction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\Deduction as DeductionResource;
use App\Http\Controllers\API\BaseController as BaseController;

class DeductionController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deduction = Deduction::all();
        return $this->sendResponse(DeductionResource::collection($deduction), 'Deductions fetched.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $input = $request->all();
        // // # add validator dri
        try {
            $deduction = Deduction::create($input);
            activity("Maintenance")->event("created")->performedOn($deduction)
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = $this->transactionDate();
                })
                ->log("Deduction Rate - Deduction Create");
        } catch (\Exception $e) {
            return new JsonResponse([
                'errors' => $e->getMessage(),
                'message' => 'Transaction Failed.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(new DeductionResource($deduction), 'Deduction Created');
        // return 'test';
    }

    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction)
    {
        return $this->sendResponse(new DeductionResource($deduction), 'Deduction fetched.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deduction $deduction)
    {
        $input = $request->all();
        try {
            $deduction->name = isset($input['name']) ? $input['name'] : $deduction->name;
            $deduction->rate = isset($input['rate']) ? $input['rate'] : $deduction->rate;
            $deduction->product_id = isset($input['product_id']) ? $input['product_id'] : $deduction->product_id;
            $deduction->term_start = isset($input['term_start']) ? $input['term_start'] : $deduction->term_start;
            $deduction->term_end = isset($input['term_end']) ? $input['term_end'] : $deduction->term_end;
            $deduction->age_start = isset($input['age_start']) ? $input['age_start'] : $deduction->age_start;
            $deduction->age_end = isset($input['age_end']) ? $input['age_end'] : $deduction->age_end;
            $deduction->deleted = isset($input['deleted']) ? $input['deleted'] : $deduction->deleted;
            $deduction->status = isset($input['status']) ? $input['status'] : $deduction->status;
            $deduction->save();
            activity("Maintenance")->event("updated")->performedOn($deduction)
                ->withProperties(['attributes' => $deduction->getDirty(), 'old' => $deduction->getOriginal()])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = $this->transactionDate();
                })
                ->log("Deduction Rate - Deduction Update");
        } catch (\Exception $e) {
            return new JsonResponse([
                'errors' => $e->getMessage(),
                'message' => 'Transaction Failed.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(new DeductionResource($deduction), 'Deduction Updated.');
    }
    public function calculateDeductions(Request $request)
    {
        $loanAmount = $request->loan_amount;
        $productId = $request->product_id;
        $terms = $request->terms;
        $age = null;
        if ($request->birthdate) {
            $birthdate = Carbon::parse($request->birthdate);
            $releasedatenow = Carbon::now();
            $age = round($birthdate->diffInDays($releasedatenow) / 365, 0);
        }
        $deduction = new Deduction();
        return $this->sendResponse($deduction->deductions([
            'loan_amount' => $loanAmount,
            'terms' => $terms,
            'product_id' => $productId,
            'age' =>  $age
        ]), 'Deductions.');
    }

    public function destroy($id)
    {
        try {
            $deduction = Deduction::find($id);
            $replicate = $deduction->replicate();
            $deduction->delete();
        } catch (\Exception $e) {
            return new JsonResponse([
                'errors' => $e->getMessage(),
                'message' => 'Transaction Failed.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(['status' => 'Deduction deleted'], 'Deleted');
    }
}
