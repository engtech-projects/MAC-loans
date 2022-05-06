<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function createAmortizationSched(LoanAccount $account, $dateRelease = null) {

        $product = Product::find($account->product_id);
        $terms = $account->terms / 30;
        $interestAmount = $account->loan_amount * ($product->interest_rate / 100) * $terms;
        $installments = $account->no_of_installment;

        if( $dateRelease ){
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $dateRelease);
        }else{
            $amortizationDateStart = Carbon::createFromFormat('Y-m-d', $account->date_release);
        }

        $principal = round($account->loan_amount / $installments);
        $interest = round($interestAmount / $installments);
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
        }

        for ($i=0; $i < $installments; $i++) { 

            $amortizationDate = $amortizationDateStart->addDays($days);
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
            // deducting total(principal+interest) from total amount (loan amount+interest)
            $totalAmount -= $total;

            if( $totalAmount <= 0 ){
                $principal = $principal + $totalAmount;
                $total = $total + $totalAmount;
            }

            $amortization[] = [
                'loan_account_id' => $account->loan_account_id,
                'amortization_date' => $amortizationDate->toDateString(),
                'principal' => number_format($principal, 2),
                'interest' => number_format($interest, 2),
                'total' => number_format($total, 2),
                'principal_balance' => number_format($principalBalance, 2),
                'interest_balance' => number_format($interestBalance, 2),
                'status' => 'open',
            ];

            $amortizationDateStart = $amortizationDate;
        }

        return $amortization;
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
}
