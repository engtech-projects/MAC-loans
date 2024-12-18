<?php

namespace App\Services\Reports;

use App\Models\AccountOfficer;
use App\Models\V2\LoanAccount;
use DeepCopy\Filter\Filter;
use Illuminate\Support\Facades\Log;

class LoanReports
{
    public static function getAccountOfficerReport($asOf, $branch = false, $aoId = false)
    {
        $allLoanAccounts = LoanAccount::with(["paidPayments", "amortizations.account"])
        ->when($branch, function ($query) use ($branch) { return $query->inBranchCode($branch); })
        ->when($aoId, function ($query) use ($aoId) { return $query->byAccountOfficerId($aoId); })
        ->released()
        ->releasedBefore($asOf)
        // ->inProgress()
        // ->limit(2)
        ->get();
        // Log::info($allLoanAccounts);
        // SEGGREGATE BY AO AND BY PRODUCTS
        $seggregatedAccounts = $allLoanAccounts->groupBy(["ao_id", "product_id"]);
        $mappedAccounts = $seggregatedAccounts->map(function ($accountsByProduct, $aoId) use ($asOf) {
            $aOfficer = AccountOfficer::find($aoId);
            return [
                "ao_id" => $aoId,
                "name" => $aOfficer->name,
                "products" => $accountsByProduct->map(function ($accounts, $productId) use ($asOf) {
                    $accountsRemapped = $accounts->map(function ($account) use ($asOf) {
                        $balanceAsOf = $account->loan_amount - $account->paidPayments->where("transaction_date", "<=", $asOf)->sum("principal");
                        // $minimumPrincipalBalance = $account->amortizations->where("delinquent_date", $asOf)->first()?->principal_amount ?? $account->loan_amount;
                        $minimumPrincipalBalance = $account->amortizations->filter(function ($amort) use ($asOf) {
                            return $amort->delinquent_date->lte($asOf);
                        })->sortByDesc("principal_balance")->values()->all()[0]?->principal_balance ?? $account->loan_amount;
                        return [
                            "account_id" => $account->loan_account_id,
                            "loan_amount" => $account->loan_amount,
                            "loan_status" => $account->loan_status,
                            "principal_balance_as_of" => $balanceAsOf,
                            "is_delinquent_as_of" => $minimumPrincipalBalance < $balanceAsOf,
                            // "minimum_principal_balance" => $minimumPrincipalBalance,
                        ];
                    })->filter(function($account) {
                        return $account['principal_balance_as_of'] > 0;
                    });
                    $delinquentAccounts = $accountsRemapped->filter(function ($account) {
                        return $account['is_delinquent_as_of'];
                    });
                    $pastDueAccounts = $accountsRemapped->filter(function ($account) {
                        return $account['loan_status'] === LoanAccount::LOAN_PASTDUE;
                    });
                    $allAmount = $accountsRemapped->sum('principal_balance_as_of');
                    $delinquentAmount = $delinquentAccounts->sum('principal_balance_as_of');
                    $pastDueAmount = $pastDueAccounts->sum('principal_balance_as_of');
                    return [
                        "product_id" => $productId,
                        "product_code" => $productId,
                        "product_name" => $accounts->first()->product->product_name,
                        "all" => [
                            'count' => $accountsRemapped->count(),
                            'total_loan_amount' => $accountsRemapped->sum('loan_amount'),
                            'amount' => $allAmount,
                            'rate' => 0,
                        ],
                        "delinquent" => [
                            'count' => $delinquentAccounts->count(),
                            'total_loan_amount' => $delinquentAccounts->sum('loan_amount'),
                            'amount' => $delinquentAmount,
                            'rate' => $allAmount ? round($delinquentAmount / $allAmount * 100, 2) : 0,
                        ],
                        "pastdue" => [
                            'count' => $pastDueAccounts->count(),
                            'total_loan_amount' => $pastDueAccounts->sum('loan_amount'),
                            'amount' => $pastDueAmount,
                            'rate' => $allAmount ? round($pastDueAmount / $allAmount * 100, 2) : 0,
                        ],
                        'account_ids' => $accounts->map(function ($account) { // KEEP FOR EASIER DEBUGGING TO IDENTIFY WHICH ACCOUNTS ARE INCLUDED
                            return $account->loan_account_id;
                        })->implode(","),
                    ];
                })->values()->filter(function ($product) {
                    return $product['all']['amount'] > 0;
                })->values()->all(),
            ];
        });
        return $mappedAccounts->values()->filter(function ($account) {
            return sizeof($account['products']) > 0;
        })->values()->all();
    }
}
