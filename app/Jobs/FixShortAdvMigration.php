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
        $accountsArray = LoanAccountMigrationFix::offset($this->i * $this->limit)->limit($this->limit)->get()->pluck('loan_account_id');
        foreach($accountsArray as $acc){
            LoanAccountController::fixMigration($acc);
        }
    }
}
