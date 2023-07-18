<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Amortization extends Model
{
    use HasFactory;

    protected $table = 'amortization';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'loan_account_id',
    	'amortization_date',
    	'principal',
    	'interest',
    	'total',
    	'principal_balance',
    	'interest_balance',
    	'status'
    ];

    protected $casts = [
        'total' => 'float',
        'interest' => 'float',
        'principal_balance' => 'float',
        'interest_balance' => 'float',
        'status' => 'string',
        'principal' => 'float'
    ];

    /* public function getPreferencesAttribute($value)
    {
        // Accessing the "preferences" attribute will automatically decode the JSON string
        return json_decode($value, true);
    }

    public function setPreferencesAttribute($value)
    {
        // Setting the "preferences" attribute will automatically encode the value to JSON
        $this->attributes['preferences'] = json_encode($value);
    } */

    public function payments(){
        return $this->hasMany(Payment::class, 'amortization_id', 'id');
    }

    public function createAmortizationSched(LoanAccount $account, $dateRelease = null) {

        $interestAmount = $account->interest_amount;
        $installments = $account->no_of_installment;

        if( $dateRelease ){
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $dateRelease);
        }else{
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $account->date_release);
        }

        $principal = ceil($account->loan_amount / $installments);
        $interest = ceil($interestAmount / $installments);
        $principalBalance = $account->loan_amount;
        $interestBalance = $interestAmount;
        $totalAmount = $account->loan_amount + $interestAmount;

        $amortizaton = array();
        $days = null;

        if( $account->payment_mode == "Weekly" ){
            $days = 7;
        }else if( $account->payment_mode == "Bi-Monthly" ) {
            $days = 15;
        }else if( $account->payment_mode == "Monthly" ) {
            $days = 30;
        }else if( $account->payment_mode == "Lumpsum") {
            $days = $account->terms;
        }

        for ($i=0; $i < $installments; $i++) {

            $amortizationDate = $amortizationDateStart->addDays($days);
            $total = $principal + $interest;

            $principalBalance = $principalBalance - $principal;



            $interestBalance = $interestBalance - $interest;

            // if( max($interestBalance, 0) == 0 ) {
            //     $interestBalance = 0;
            // }
            // deducting total(principal+interest) from total amount (loan amount+interest)
            $totalAmount -= $total;

            if( $totalAmount <= 0 ){
                $principal = ($principal) - abs($principalBalance);
                $interest = ($interest) - abs($interestBalance);
                if( $principalBalance < 0 ){
                    $principalBalance = 0;
                }

                if( $interestBalance < 0 ){
                    $interestBalance = 0;
                }

                $total = $total + $totalAmount;
            }
            $amortization[] = [
                'loan_account_id' => $account->loan_account_id,
                'amortization_date' => $amortizationDate->toDateString(),
                'principal' => number_format($principal, 2),
                'interest' => number_format(strtolower($account->type) != "prepaid" ? $interest : 0, 2),
                'total' => number_format(strtolower($account->type) != "prepaid" ? $total : $principal, 2),
                'principal_balance' => number_format($principalBalance, 2),
                'interest_balance' => number_format(strtolower($account->type) != "prepaid" ? $interestBalance : 0, 2),
                'status' => 'open',
            ];

            $amortizationDateStart = $amortizationDate;
        }

        return $amortization;
    }

    public function specialSchedule(LoanAccount $account, $dateRelease = null) {

        if( $dateRelease ){
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $dateRelease);
        }else{
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $account->date_release);
        }

        $interestAmount = $account->interest_amount;
        $installments = $account->no_of_installment;
        $principal = ceil($account->loan_amount / $installments);
        $interest = ceil($interestAmount / $installments);
        $principalBalance = $account->loan_amount;
        $interestBalance = $interestAmount;
        $totalAmount = $account->loan_amount + $interestAmount;

        $amortizaton = array();
        $dateArr = [];

        $dateSched =  $this->getSpecialSched($amortizationDateStart);
        $schedules = $this->buildSched($dateSched, $installments);

        for ($i=0; $i < $installments; $i++) {

            $total = $principal + $interest;
            // principal balance
            $principalBalance = $principalBalance - $principal;

            if( max($principalBalance, 0) == 0 ) {
                $principalBalance = 0;
            }

            $interestBalance = $interestBalance - $interest;

            if( max($interestBalance, 0) == 0 ) {
                $interestBalance = 0;
            }

            $totalAmount -= $total;

            if( $totalAmount <= 0 ){
                $principal = $principal + $totalAmount;
                $total = $total + $totalAmount;
            }

            $amortization[] = [
                'loan_account_id' => $account->loan_account_id,
                'amortization_date' => $schedules[$i],
                'principal' => number_format($principal, 2),
                'interest' => number_format($interest, 2),
                'total' => number_format($total, 2),
                'principal_balance' => number_format($principalBalance, 2),
                'interest_balance' => number_format($interestBalance, 2),
                'status' => 'open',
            ];
        }

        return $amortization;
    }

    public function getSpecialSched(Carbon $dateRelease) {

        $first = $dateRelease->addDays(12)->toDateString();
        $second = $dateRelease->addDays(12)->toDateString();

        return [ Carbon::createFromFormat('Y-m-d', $first) , Carbon::createFromFormat('Y-m-d', $second) ];
    }

    public function addMonthToSched(Carbon $schedDate, $initial = false, $initialDay) {

        return $this->checkLeapMonth($schedDate, $initial, $initialDay);
    }

    public function buildSched(Array $initialSched, $installments) {

        $initial = true;
        $firstArr = [];
        $secondArr = [];

        $firstDay = $initialSched[0]->day;
        $secondDay = $initialSched[1]->day;

        for ($i=0; $i < ($installments/2); $i++) {

            $firstArr[] = $this->addMonthToSched($initialSched[0], $initial, $firstDay);
            $secondArr[] = $this->addMonthToSched($initialSched[1], $initial, $secondDay);

            $initial = false;
        }

        $schedules = array_merge($firstArr, $secondArr);
        usort($schedules, array($this, 'cmp'));

        return $schedules;
    }

    public function checkLeapMonth(Carbon $schedDate, $initial = false, $initialDay) {

        if( $initial ) {
            return $schedDate->toDateString();
        }

        $month = $schedDate->month;
        $day = $schedDate->day;

        $schedDate->addMonthNoOverflow();
        if($initialDay <= $schedDate->daysInMonth){
            $schedDate->day = $initialDay;
        }

        return $schedDate->toDateString();
    }

    function cmp($a, $b){
        $ad = strtotime($a);
        $bd = strtotime($b);
        return ($ad-$bd);
    }

    public function storeAmortizationSched(LoanAccount $account) {

        $amortizationSched = $this->createAmortizationSched($account);

        foreach ($amortizationSched as $key => $value) {

            $data = array(
                'loan_account_id' => $value['loan_account_id'],
                'amortization_date' => $value['amortization_date'],
                'principal' =>  floatval(preg_replace('/[^\d.]/', '', $value['principal'])),
                'interest' =>  floatval(preg_replace('/[^\d.]/', '', $value['interest'])),
                'total' =>  floatval(preg_replace('/[^\d.]/', '', $value['total'])),
                'principal_balance' =>  floatval(preg_replace('/[^\d.]/', '', $value['principal_balance'])),
                'interest_balance' =>  floatval(preg_replace('/[^\d.]/', '', $value['interest_balance'])),
                'status' => 'open',
            );
            Amortization::create($data);
        }

        return $amortizationSched;
    }

    public static function getAmortizationStatus($loan_account_id) {
        $amortization = Amortization::find($loan_account_id);
        return $amortization->status;
    }


    public function getDelinquents($amort_id) {
        $amortization = Amortization::find($amort_id);
        return $amortization->status;
    }


}
