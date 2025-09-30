<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\LoanAccount;
use App\Models\Amortization;
use App\Models\Borrower;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PaymentLoanAccount as PaymentLoanAccountResource;
use Carbon\Carbon;
use App\Models\EndTransaction;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class PaymentController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $payments = Payment::all();
        // return $this->sendResponse(PaymentResource::collection($payments), 'Payments');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            # create payment instance.
            $payment = new Payment();
            # get branch id and add to request data
            // $request->merge(['branch_id' => 2]);

            // $payment->addPayment($request);
            $endTransaction = new EndTransaction();
            $dateEnd = $endTransaction->getTransactionDate($request->input("branch_id"));
            if ($dateEnd->status !== 'open') {
                return $this->sendError("Transaction Date is Closed.", $dateEnd);
            }
            $pendingPayment = $payment->getOngoingPayment($request->input());
            if ($pendingPayment) {
                $message = "There is still a pending payment for this account, please override " . ($pendingPayment->or_no ? "OR #: " . $pendingPayment->or_no : "Ref. #: " . $pendingPayment->reference_no);
                return $this->sendError("Failed fetch account.", $message);
            }
            $loanAccount = LoanAccount::where('loan_account_id', $request->input('reference_id'))->first();
            if ($loanAccount) {
                $payment->deleteMemoPaymentIfExists($loanAccount);
            }

            $paymentRes = $payment->addPayment($request);
            $sourcePage = $request->input('source', 'unknown');
            $activityName = $this->getActivityNameFromRoute($sourcePage);
            $logMessage = ($activityName === 'Repayment Entry') ? 'Payment - Create' : 'Memo Payment - Create';
            activity($activityName)->event("created")->performedOn($paymentRes)
                ->withProperties(['model_snapshot' => $paymentRes->toArray()])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
                ->log($logMessage);
            
            return $this->sendResponse(new PaymentResource($paymentRes), 'Payment');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if it's a deadlock error (error code 1213)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1213) {
                $message = "Payment is being processed by another request. Please wait and try again.";
                return $this->sendError("Payment is unsuccessful.", $message);
            }
            throw $e;
        }
    }



    /* Check loan account if it is PAID or
        if have PENDING payments to override
     */
    public function checkLoanAccount(Request $request)
    {
        $loanAccount = new LoanAccount();
        $accountId = $request->input()["loan_account_id"];
        $account = $loanAccount->getLoanAccount($accountId);
        //Check loan account exist.
        if ($account) {
            $pendingPayments = $account->pendingPayments->first();

            //Check loan account payments if there is pending payments.
            if ($pendingPayments) {
                $message = "There is still a pending payment for this account, please override " . ($pendingPayments->or_no ? "OR #: " . $pendingPayments->or_no : "Ref. #: " . $pendingPayments->reference_no);
                return $this->sendError("Pending Payment.", $message, 422);
            }
            //Check loan account if it is already paid.
            if ($account->loan_status == $loanAccount::LOAN_PAID) {
                $message = "This account is already paid, please check the statement of account";
                return $this->sendError("Account Paid.", $message, 422);
            }
        }
        return $this->sendResponse(null, "Account is open for payment");
    }


    // Override Payment
    public function overridePaymentList(Request $request)
    {

        $filters = [
            'transaction_date' => ($request->has('transaction_date')) ? $request->input('transaction_date') : false,
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : false,
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : false,
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : false,
            'branch_id' => $request->input('branch_id')
        ];

        $payment = new Payment();

        return $this->sendResponse(
            PaymentLoanAccountResource::collection($payment->overridePaymentAccounts($filters)),
            'Payments'
        );
    }

    public function overridePayment(Request $request)
    {

        $payment = null;


        $succeed = 0;
        $failed = 0;
        foreach ($request->input() as $key => $value) {

            $payment = Payment::find($value['payment_id']);
            $paymentReplicate = $payment->replicate();
            $amortization = Amortization::find($payment->amortization_id);
            $loanAccount = LoanAccount::find($payment->loan_account_id);
            $paymentMode = $loanAccount->payment_mode;
            if ($payment->reference_id) {
                $acc = LoanAccount::find($payment->reference_id);

                if ($acc->status == 'pending') {
                    $failed++;
                    continue;
                }
            }

            $succeed++;
            $payment->status = 'paid';
            $payment->save();

            $paymentChanges = $this->getChanges($payment, $paymentReplicate);
            unset($paymentChanges['attributes']['updated_at'], $paymentChanges['old']['updated_at']);
            $logName = $payment->memo_type === "deduct to balance"?"Memo Payment - Override":"Payment - Override";
            activity("Override Payment")->event("updated")->performedOn($payment)
                ->withProperties([
                    'model_snapshot' => $payment->toArray(),
                    'attributes' => $paymentChanges['attributes'], 
                    'old' => $paymentChanges['old']
                ])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
                ->log($logName);

            # update amortization
            if ($amortization->principal_balance < $loanAccount->remainingBalance()["principal"]["balance"] || $amortization->interest_balance < $loanAccount->remainingBalance()["interest"]["balance"]) {

                $currentDay = transactionDate($payment->branch_id);
                $schedDate = $paymentMode === 'Monthly' ? $amortization->amortization_date->endOfMonth() : $amortization->amortization_date->startOfDay();

                if ($currentDay < $schedDate) {
                    $amortization->status = 'open';
                } else {
                    $amortization->status = 'delinquent';
                }
            } else {
                $amortization->status = 'paid';
                $loanAccount->payment_status = 'Current';
            }

            $balance = $loanAccount->outstandingBalance($loanAccount->loan_account_id);

            if ($balance <= 0) {
                $loanAccount->payment_status = 'Paid';
                $loanAccount->loan_status = 'Paid';
            }

            $amortization->save();
            $loanAccount->save();
        }

        $sf = $succeed + $failed;
        return $this->sendResponse("{$succeed} of {$sf} Successfully Overriden", 'Override');
    }

    public function overrideList(Request $request)
    {

        $branchId = $request->input('branch_id');

        $eod = transactionDate($branchId);

        $payment = new Payment();
        $list = $payment->overriddenList(array('branch_id' => $branchId, 'transaction_date' => $eod->date_end));

        if (count($list) > 0) {
            return $this->sendResponse(PaymentLoanAccountResource::collection($list), 'Payments');
        }

        return false;
    }

    public function destroy($id)
    {

        $payment = Payment::find($id);
        $paymentData = $payment->toArray();
        $payment->delete();

        activity("Override Payment")->event("deleted")->performedOn($payment)
            ->withProperties([
                'model_snapshot' => $paymentData,
                'old' => $paymentData
            ])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = null;
            })
            ->log("Payment - Delete");
        return $this->sendResponse(['status' => 'Payment deleted'], 'Deleted');
    }

    public function updatePayment(UpdatePaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated($request);
        $payment->fill($validated);
        $payment->save();
        return $this->sendResponse(new PaymentResource($payment), 'Payment successfully updated');
    }

    public function update(Request $request, Payment $payment)
    {

        $paymentReplicate = $payment->replicate();
        $payment->fill($request->input());
        $payment->save();

        if ($payment->status == 'cancelled') {

            if ($payment->amortization_id) {

                $amortization = Amortization::find($payment->amortization_id);
                $amortization->status = 'open';
                $amortization->save();
            }

            if ($payment->loan_account_id) {

                $account = LoanAccount::find($payment->loan_account_id);

                if (Str::lower($account->status) == 'paid') {
                    $account->loan_status = 'Ongoing';
                    $account->save();
                }

                $paymentChanges = $this->getChanges($payment, $paymentReplicate);
                unset($paymentChanges['attributes']['updated_at'], $paymentChanges['old']['updated_at']);
                
                activity("Cancel Payments")->event("updated")->performedOn($payment)
                    ->withProperties([
                        'model_snapshot' => $payment->toArray(),
                        'attributes' => $paymentChanges['attributes'], 
                        'old' => $paymentChanges['old']
                    ])
                    ->tap(function (Activity $activity) {
                        $activity->transaction_date = null;
                    })
                    ->log("Payment - Cancel");
                return $this->sendResponse(new PaymentResource($payment), 'Payment Cancelled.');
            }
        }
        return $this->sendResponse(new PaymentResource($payment), 'Payment Updated.');
    }

    public function show($branchId) {}

    public function paymentSummary($branchId)
    {


        $dateEnd = transactionDate($branchId);

        $payment = new Payment();
        $paymentList = $payment->paymentList($dateEnd, $branchId);

        $summary = [
            'cash' => 0,
            'check' => 0,
            'memo' => 0,
            'total' => 0,
        ];
        if (count($paymentList) > 0) {

            foreach ($paymentList as $payment) {

                if (Str::contains(Str::lower($payment->payment_type), 'cash')) {

                    $summary['cash'] += $payment->amount_applied;
                    continue;
                }

                if (Str::contains(Str::lower($payment->payment_type), 'check')) {

                    $summary['check'] += $payment->amount_applied;
                    continue;
                }

                if (Str::contains($payment->payment_type, 'memo')) {

                    $summary['memo'] += $payment->amount_applied;
                    continue;
                }
            }
            $summary['total'] = $summary['cash'] + $summary['check'] + $summary['memo'];
        }

        return $summary;
    }

    public function cancelPaymentList(Request $request)
    {
        $payments = Payment::where(['transaction_date' => $request->transaction_date, 'branch_id' => $request->branch_id])->get();
        foreach ($payments as $payment) {
            $account = LoanAccount::find($payment->loan_account_id);
            $borrower = Borrower::find($account->borrower_id);
            $account->borrower->photo = $borrower->getPhoto();
            $payment->account = $account;
        }

        return $payments;
    }

    private function getActivityNameFromRoute($routePath)
    {
        if (str_contains($routePath, '/repayment_entry')) {
            return 'Repayment Entry';
        }
        
        if (str_contains($routePath, '/rejected_release')) {
            return 'Rejected Release';
        }
        
        if (str_contains($routePath, '/release_entry')) {
            return 'Release Entry';
        }
        
        return 'Payment Management';
    }
}
