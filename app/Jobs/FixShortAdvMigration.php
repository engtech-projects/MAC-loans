<?php

namespace App\Jobs;

use App\Http\Controllers\API\LoanAccountController;
use App\Models\Amortization;
use App\Models\EndTransaction;
use App\Models\LoanAccountMigrationFix;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FixShortAdvMigration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $i;
    private $limit;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($i, $limit)
    {
        $this->i = $i;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $accountsArray = LoanAccountMigrationFix::with(['lastPayment', 'branch.endTransaction', 'amortizations', 'amortizations.payments'])->offset($this->i * $this->limit)->limit($this->limit)->get();
        foreach($accountsArray as $acc){
            $amortP = 0;
            $amortI = 0;
            $advP = 0;
            $advI = 0;
            $shortP = 0;
            $shortI = 0;
            $principal = $acc->loan_amount;
            $interest = $acc->interest_amount;
            foreach($acc->amortizations as $amort){
                $amortP += round($amort->principal);
                $amortI += round($amort->interest);
                $principal -= round($amort->principal;
                $interest -= round($amort->interest);
                $currentAmortP = $principal < 0 ? round($amort->principal - abs($principal): round($amort->principal;
                $principal = $principal < 0 ? 0: $principal;
                $currentAmortI = $interest < 0 ? round($amort->interest) - abs($interest) : round($amort->interest);
                $interest = $interest < 0 ? 0: $interest;
                foreach($amort->payments as $payment){
                    $payment->principal += $advP;
                    $payment->interest += $advI;
                    $shortP = $amortP < $payment->principal ? 0 : $amortP - $payment->principal;
                    $advP = $amortP < $payment->principal ? $payment->principal - $amortP : 0;
                    $shortI = $amortI < $payment->interest ? 0 : $amortI - $payment->interest;
                    $advI = $amortI < $payment-> interest ? $payment->interest - $amortI : 0;
                    $totalPayable = $payment->amount_applied + $shortI + $shortP;
                    if($acc->lastPayment && $acc->lastPayment->payment_id == $payment->payment_id && $shortP > 0){
                        if($acc->branch->endTransaction->date_end <= $amort->amortization_date){
                            Amortization::find($amort->id)->fill([
                                'status' => 'open'
                            ])->save();
                        }else{
                            Amortization::find($amort->id)->fill([
                                'status' => 'delinquent'
                            ])->save();

                            LoanAccountMigrationFix::find($acc->loan_account_id)->fill([
                                'payment_status' => 'Delinquent'
                            ])->save();
                        }
                    }
                    Payment::find($payment->payment_id)->fill([
                        "total_payable" => $totalPayable,
                        "short_interest"=> $shortI,
                        "short_principal"=> $shortP,
                        "advance_interest"=> $advI,
                        "advance_principal"=> $advP,
                    ])->save();
                    $amortP -= $payment->principal > $amortP ? $amortP : $payment->principal;
                    $amortI -= $payment->interest > $amortI ? $amortI : $payment->interest;
                }
                if($amort->status != 'paid' && $acc->branch->endTransaction->date_end > $amort->amortization_date){
                    Amortization::find($amort->id)->fill([
                        'status' => 'delinquent'
                    ])->save();

                    LoanAccountMigrationFix::find($acc->loan_account_id)->fill([
                        'payment_status' => 'Delinquent'
                    ])->save();
                }
                Amortization::find($amort->id)->fill([
                    'principal_balance' => $principal,
                    'interest_balance' => $interest,
                    'principal' => $currentAmortP,
                    'interest' => $currentAmortI,
                    'total' => $currentAmortP + $currentAmortI,
                ])->save();
            }

        }


    }
}
