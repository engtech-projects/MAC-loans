<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Deduction as DeductionResource;
use App\Models\Deduction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

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
            activity("Deduction Rate - Create")->event("created")->performedOn($deduction)
                ->createdAt(now())
                ->log("Deduction Rate - Created");
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
        $replicate = $deduction->replicate();
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
            activity("Deduction Rate - Edit")->event("updated")->performedOn($deduction)
                ->withProperties(['attributes' => $deduction, 'old' => $replicate])
                ->createdAt(now())
                ->log("Deduction Rate - Edited");
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
            $age = Carbon::parse($request->birthdate)->diff(Carbon::now())->format('%y');
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
            $deduction->delete();
            activity("Deduction Rate - Delete")->event("deleted")->performedOn($deduction)
                ->createdAt(now())
                ->log("Deduction Rate - Deleted");
        } catch (\Exception $e) {
            return new JsonResponse([
                'errors' => $e->getMessage(),
                'message' => 'Transaction Failed.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(['status' => 'Deduction deleted'], 'Deleted');
    }
}
