<?php

namespace App\Jobs;

use App\Http\Controllers\API\LoanAccountController;
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
        $accountsArray = LoanAccountMigrationFix::with(['lastPayment', 'branch','endTransaction', 'amortizations', 'amortizations.payments'])->offset($this->i * $this->limit)->limit($this->limit)->get();

        $tranDate = new EndTransaction();



        $dd = [];

        foreach($accountsArray as $acc){
            $transactionDateNow = $tranDate->getTransactionDate($acc->branch->branch_id)->date_end;
            $amortP = 0;
            $amortI = 0;
            $advP = 0;
            $advI = 0;
            $shortP = 0;
            $shortI = 0;
            foreach($acc->amortizations as $amort){

                // echo $amort;
                $amortP += $amort->principal;
                $amortI += $amort->interest;
                foreach($amort->payments as $payment){
                    /* dd($acc->end_of_transaction->date_end); */
                    $payment->principal += $advP;
                    $payment->interest += $advI;
                    $shortP = $amortP < $payment->principal ? 0 : $amortP - $payment->principal;
                    $advP = $amortP < $payment->principal ? $payment->principal - $amortP : 0;
                    $shortI = $amortI < $payment->interest ? 0 : $amortI - $payment->interest;
                    $advI = $amortI < $payment-> interest ? $payment->interest - $amortI : 0;
                    if($acc->lastPayment == $payment && $shortP > 0){
                        if($transactionDateNow > $amort->amortization_date){
                            $amort->status = 'open';
                        }else{
                            $amort->status = 'delinquent';
                        }
                        $amort->save();
                    }
                    Payment::find($payment->payment_id)->fill([
                        "short_interest"=> $shortI,
                        "short_principal"=> $shortP,
                        "advance_interest"=> $advI,
                        "advance_principal"=> $advP,
                    ])->save();
                    $amortP -= $payment->principal > $amortP ? $amortP : $payment->principal;
                    $amortI -= $payment->interest > $amortI ? $amortI : $payment->interest;
                }
            }

        }


    }
}
