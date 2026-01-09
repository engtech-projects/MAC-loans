<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\EndTransaction;
use App\Services\Reports\LoanReports;

class Reports extends Model
{
    use HasFactory;

    const BRANCH_AO_PERFORMANCE = "performance_report";
    const BRANCH_AO_WRITEOFF = "write_off";
    const BRANCH_AO_DELINQUENT = "delinquent";

    public function getLoanAccounts($filters = [], $without = [])
    {
        $loanAccount = Loanaccount::where(['loan_accounts.status' => 'released']);

        if (isset($filters['branch_id'])) {
            $branch = Branch::find($filters['branch_id']);

            $loanAccount->where(['loan_accounts.branch_code' => $branch->branch_code]);
        }



       /* Date released filter */
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $loanAccount->whereBetween(
                DB::raw('DATE(loan_accounts.date_release)'),
                [$filters['date_from'], $filters['date_to']]
            );
        }

        /* ✅ Due date filter — conditional */
        if (
            ($filters['report'] ?? null) === 'prepaid_interest' &&
            !empty($filters['due_from']) &&
            !empty($filters['due_to'])
        ) {
            $loanAccount->whereBetween('loan_accounts.due_date', [
                $filters['due_from'],
                $filters['due_to']
            ]);
        } else {
            if (!empty($filters['due_from'])) {
                $loanAccount->whereDate('loan_accounts.due_date', '>=', $filters['due_from']);
            }
            if (!empty($filters['due_to'])) {
                $loanAccount->whereDate('loan_accounts.due_date', '<=', $filters['due_to']);
            }
        }


        if (isset($filters['product_id']) && $filters['product_id']) {
            $loanAccount->where(['loan_accounts.product_id' => $filters['product_id']]);
        }

        if (isset($filters['cycle_no']) && $filters['cycle_no']) {
            $loanAccount->where(['loan_accounts.cycle_no' => $filters['cycle_no']]);
        }

        if (isset($filters['center']) && $filters['center']) {
            if ($filters['center'] == "No Center") {
                $loanAccount->whereNull('loan_accounts.center_id');
            } else {
                $loanAccount->where(['loan_accounts.center_id' => $filters['center']]);
            }
        }

        if (isset($filters['product']) && $filters['product']) {
            $loanAccount->where(['loan_accounts.product_id' => $filters['product']]);
        }

        if (isset($filters['account_officer']) && $filters['account_officer']) {
            $loanAccount->where(['loan_accounts.ao_id' => $filters['account_officer']]);
        }

        /* if (isset($filters['loan_status']) && $filters['loan_status']) {
            $loanAccount->where(['loan_accounts.loan_status' => $filters['loan_status']]);
        } */

        if (isset($filters['payment_status']) && $filters['payment_status']) {
            $loanAccount->where(['loan_accounts.payment_status' => $filters['payment_status']]);
        }

        if (isset($filters['type']) && $filters['type']) {
            $loanAccount->where(['loan_accounts.type' => $filters['type']]);
        }

        if (isset($filters["report"]) && $filters["report"] === "status_summary") {
            if (isset($filters["loan_status"]) && $filters["loan_status"] === LoanAccount::PAYMENT_CURRENT || $filters["loan_status"] === LoanAccount::PAYMENT_DELINQUENT) {
                return $loanAccount->where(
                    "payment_status",
                    $filters["loan_status"]
                )->where('loan_status', LoanAccount::LOAN_ONGOING)->get();
            } else {
                return $loanAccount->where(['loan_accounts.loan_status' => $filters['loan_status']])->get();
            }
        } else {
            if (isset($filters["loan_status"]) && $filters["loan_status"]) {
                $loanAccount->where(['loan_accounts.loan_status' => $filters['loan_status']]);
            }
        }
        if (isset($filters["report"]) && $filters["report"] === "release") {
            return $loanAccount->without('documents', 'payments')->get();
        }
        // ✅ Allow prepaid report to fetch ALL loan statuses
if (isset($filters['report']) && $filters['report'] === 'prepaid_interest') {
    return $loanAccount
        ->without($without)
        ->get([
            'loan_accounts.loan_account_id',
            'loan_accounts.account_num',
            'loan_accounts.date_release',
            'loan_accounts.terms',
            'loan_accounts.loan_amount',
            'loan_accounts.interest_amount',
            'loan_accounts.document_stamp',
            'loan_accounts.filing_fee',
            'loan_accounts.insurance',
            'loan_accounts.notarial_fee',
            'loan_accounts.prepaid_interest',
            'loan_accounts.affidavit_fee',
            'loan_accounts.total_deduction',
            'loan_accounts.no_of_installment',
            'loan_accounts.net_proceeds',
            'loan_accounts.borrower_id',
            'loan_accounts.product_id',
            'loan_accounts.ao_id',
            'loan_accounts.center_id',
            'loan_accounts.branch_code',
            'loan_accounts.release_type',
            'loan_accounts.cycle_no',
            'loan_accounts.memo',
            'loan_accounts.due_date',
            'loan_accounts.payment_mode',
            'loan_accounts.payment_status',
            'loan_accounts.loan_status',
            'loan_accounts.interest_rate',
        ]);
}
        return $loanAccount->whereIn('loan_status', [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE, LoanAccount::LOAN_RESTRUCTED, LoanAccount::LOAN_RES_WO_PDI, LoanAccount::LOAN_WRITEOFF])
            ->without($without)->get([
                'loan_accounts.loan_account_id',
                'loan_accounts.account_num',
                'loan_accounts.date_release',
                'loan_accounts.terms',
                'loan_accounts.loan_amount',
                'loan_accounts.interest_amount',
                'loan_accounts.document_stamp',
                'loan_accounts.filing_fee',
                'loan_accounts.insurance',
                'loan_accounts.notarial_fee',
                'loan_accounts.prepaid_interest',
                'loan_accounts.affidavit_fee',
                'loan_accounts.total_deduction',
                'loan_accounts.no_of_installment',
                'loan_accounts.net_proceeds',
                'loan_accounts.borrower_id',
                'loan_accounts.product_id',
                'loan_accounts.ao_id',
                'loan_accounts.center_id',
                'loan_accounts.branch_code',
                'loan_accounts.release_type',
                'loan_accounts.cycle_no',
                'loan_accounts.memo',
                'loan_accounts.due_date',
                'loan_accounts.payment_mode',
                'loan_accounts.payment_status',
                'loan_accounts.loan_status',
                'loan_accounts.cycle_no'
            ]);
    }

    public function getPayments($filters = [])
    {


        /* $payments = Payment::where([ 'payment.status' => 'paid'])->select('transaction_date');
        $payments->join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id'); */

        $payments = Payment::join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id')
            ->join('amortization', 'amortization.id', '=', 'payment.amortization_id')
            ->select(
                'loan_accounts.loan_account_id',
                'payment.transaction_date',
                'loan_accounts.due_date',
                'loan_accounts.borrower_id',
                'amortization.id',
                'amortization.interest as amortization_interest',
                'amortization.principal as amortization_principal',
                'payment.interest as interest',
                'payment.or_no',
                'payment.principal',
                'payment.pdi',
                'payment.pdi_approval_no',
                'payment.over_payment',
                'payment.rebates',
                'payment.amount_applied',
                'payment.vat',
                'payment.payment_type',
                'payment.memo_type',
                'loan_accounts.center_id'
            )->where(['payment.status' => 'paid']);




        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $branch = Branch::find($filters['branch_id']);
            $payments->where(['payment.branch_id' => $branch->branch_code]);
        }


        if (isset($filters['product_id'])) {
            $payments->where(['loan_accounts.product_id' => $filters['product_id']]);
        }

        if (isset($filters['product'])) {
            $payments->where(['loan_accounts.product_id' => $filters['product']]);
        }

        if (isset($filters['account_officer'])) {
            $payments->where(['loan_accounts.ao_id' => $filters['account_officer']]);
        }

        if (isset($filters['center'])) {
            $payments->where(['loan_accounts.center_id' => $filters['center']]);
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $payments->whereDate('payment.transaction_date', '>=', $filters['date_from']);
            $payments->whereDate('payment.transaction_date', '<=', $filters['date_to']);
        }
        if (isset($filters['type'], $filters['spec'])) {
            if ($filters['type'] === 'payment_status' && $filters['spec'] === 'past_due') {
                $payments->where('payment.pdi', '>', 0);

                if ($filters['waived']) {
                    $payments->whereNotNull('payment.pdi_approval_no');
                } else {
                    $payments->whereNull('payment.pdi_approval_no');
                }

                if (!empty($filters['psproduct'])) {
                    $payments->where('loan_accounts.product_id', $filters['psproduct']);
                }
                if (!empty($filters['psAO'])) {
                    $payments->where('loan_accounts.ao_id', $filters['psAO']);
                }
            } elseif ($filters['type'] === 'payment_status' && $filters['spec'] === 'current') {
                $payments->where('payment.pdi', '=', 0);

                if (!empty($filters['psproduct'])) {
                    $payments->where('loan_accounts.product_id', $filters['psproduct']);
                }
                if (!empty($filters['psAO'])) {
                    $payments->where('loan_accounts.ao_id', $filters['psAO']);
                }
            }
        }

        return $payments->get();
    }

    /* start transaction reports */
    public function transactionReports($filters = [])
    {

        $report = new Reports();

        $report->product = $this->getReleaseByProduct($filters);
        $report->client = $this->getReleaseByClient($filters);

        return $report;
    }

    public function getReleaseByProduct($filters)
    {
        // if( isset($filters['product']) && $filters['product'] ){
        //     $products = Product::where([ 'status' => 'active', 'product_id' => $filters['product'] ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        // }else{
        $products = Product::where(['status' => 'active'])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        // }

        $paymentTypes = config('enums.payment_type');

        $data = [];


        foreach ($products as $key => $product) {

            $data[$key]['reference'] = $product->reference = $product->product_code . ' - ' . $product->product_name;
            $data[$key]['release'] = [
                'principal' => 0,
                'interest' => 0,
                'document_stamp' => 0,
                'filing_fee' => 0,
                'insurance' => 0,
                'notarial_fee' => 0,
                'prepaid_interest' => 0,
                'affidavit_fee' => 0,
                'total_deduction' => 0,
                'net_proceeds' => 0,
                'memo' => 0,
                'cash' => 0,
                'check' => 0,
            ];

            $data[$key]['payment'] = [];

            $accounts = null;
            $payments = null;

            $filters['product_id'] = $product->product_id;

            $accounts = $this->getLoanAccounts($filters);
            $payments = $this->getPayments($filters);

            if (count($accounts)) {

                foreach ($accounts as $account) {

                    $data[$key]['release']['principal'] += $account->loan_amount;
                    $data[$key]['release']['interest'] += $account->interest_amount;
                    $data[$key]['release']['document_stamp'] += $account->document_stamp;
                    $data[$key]['release']['filing_fee'] += $account->filing_fee;
                    $data[$key]['release']['insurance'] += $account->insurance;
                    $data[$key]['release']['notarial_fee'] += $account->notarial_fee;
                    $data[$key]['release']['prepaid_interest'] += $account->prepaid_interest;
                    $data[$key]['release']['affidavit_fee'] += $account->affidavit_fee;
                    $data[$key]['release']['total_deduction'] += $account->total_deduction;
                    $data[$key]['release']['net_proceeds'] += $account->net_proceeds;
                    $data[$key]['release']['memo'] += $account->memo;

                    if (str_contains(strtolower($account->release_type), 'cash')) {
                        $data[$key]['release']['cash'] += $account->net_proceeds;
                    }

                    if (str_contains(strtolower($account->release_type), 'check')) {
                        $data[$key]['release']['check'] += $account->net_proceeds;
                    }
                }
            }


            if (count($payments)) {

                foreach ($payments as $k => $payment) {

                    foreach ($paymentTypes as $type) {

                        if ($payment->payment_type == $type) {

                            if (!isset($data[$key]['payment'][$type])) {
                                $data[$key]['payment'][$type] = [

                                    'principal' => 0,
                                    'interest' => 0,
                                    'pdi' => 0,
                                    'over' => 0,
                                    'discount' => 0,
                                    'total_payment' => 0,
                                    'net_int' => 0,
                                    'vat' => 0
                                ];
                            }

                            $data[$key]['payment'][$type]['principal'] += $payment->principal;
                            $data[$key]['payment'][$type]['interest'] += $payment->interest;
                            $data[$key]['payment'][$type]['pdi'] += ($payment->pdi_approval_no) ? 0 : $payment->pdi;
                            $data[$key]['payment'][$type]['over'] += $payment->over_payment;
                            $data[$key]['payment'][$type]['discount'] += $payment->rebates;
                            $data[$key]['payment'][$type]['total_payment'] += $payment->amount_applied - $payment->rebates;
                            $data[$key]['payment'][$type]['net_int'] += $payment->interest;
                            $data[$key]['payment'][$type]['vat'] += $payment->vat;
                            if ($payment->memo_type) {
                                if (!isset($data[$key]['payment'][$type]["memo"][$payment->memo_type])) {
                                    $data[$key]['payment'][$type]["memo"][$payment->memo_type] = 0;
                                }
                                $data[$key]['payment'][$type]["memo"][$payment->memo_type] += $payment->amount_applied - $payment->rebates;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function getReleaseByClient($filters, $collection = true)
    {

        $data = [
            'release' => [], // Initialize release array
            'collection' => [] // Initialize collection array
        ];
        $accounts = $this->getLoanAccounts($filters);
        $payments = $this->getPayments($filters);


        foreach ($accounts as $account) {

            $data['release'][] = [
                'cycle_no' => $account->cycle_no,
                'product_id' => $account->product_id,
                'account_num' => $account->account_num,
                'borrower' => $account->borrower?->fullname(),
                'date_loan' => $account->date_release,
                'date_release' => $account->date_release,
                'term' => $account->terms,
                'amount_loan' => $account->loan_amount,
                'filing_fee' => $account->filing_fee,
                'document_stamp' => $account->document_stamp,
                'insurance' => $account->insurance,
                'notarial_fee' => $account->notarial_fee,
                'affidavit_fee' => $account->affidavit_fee,
                'deduction' => $account->total_deduction,
                'prepaid_interest' => $account->prepaid_interest,
                'net_proceeds' => $account->net_proceeds,
                'memo' => $account->memo,
                'type' => $account->release_type,
            ];
        }

        $sortedData = collect($data['release'])->sortBy([
            ['borrower', 'asc'],
            ['date_release', 'asc']
        ])->values();

        $data['release'] = $sortedData;

        if (!$collection) {

            return $data;
        }

        foreach ($payments as $payment) {

            $borrower = LoanAccount::find($payment->loan_account_id);
            /* if($borrower) { */
            $data['collection'][] = [
                'borrower' => $borrower ? Borrower::find($borrower->borrower_id)?->fullname() : '',
                'date_paid' => $payment->transaction_date,
                'or' => $payment->or_no,
                'payment_type' => $payment->payment_type,
                'principal' => $payment->principal,
                'interest' => $payment->interest,
                'pdi' => ($payment->pdi_approval_no) ? 0 : $payment->pdi,
                'over' => $payment->over_payment,
                'discount' => $payment->rebates,
                'total_payment' => $payment->amount_applied - $payment->rebates,
                'net_int' => $payment->interest,
                'vat' => $payment->vat,
                'memo_type' => $payment->memo_type
            ];
            //}

        }

        // foreach ($accounts as $account) {

        //     $client['summary'][] = [
        //                 'account_num' => $account->account_num,
        //                 'borrower' => $account->borrower->fullname() ,
        //                 'date_loan' => $account->date_release,
        //                 'date_release' => $account->date_release,
        //                 'term' => $account->terms,
        //                 'amount_loan' => $account->loan_amount,
        //                 'filing_fee' => $account->filing_fee,
        //                 'document_stamp' => $account->document_stamp,
        //                 'insurance' => $account->insurance,
        //                 'notarial_fee' => $account->notarial_fee,
        //                 'affidavit_fee' => $account->affidavit_fee,
        //                 'deduction' => $account->total_deduction,
        //                 'prepaid_interest' => $account->prepaid_interest,
        //                 'net_proceeds' => $account->net_proceeds,
        //                 'memo' => $account->memo,
        //                 'type' => $account->release_type,
        //             ];

        //     if( !$collection ) continue;

        //     if( count($account->payments) ) {

        //         foreach ($account->payments as $payment) {

        //             $client['collection'][] = [
        //                     'borrower' => $account->borrower->fullname(),
        //                     // 'date_paid' => Carbon::createFromFormat('Y-m-d', $payment->transaction_date)->format('Y-m-d'),
        //                     'date_paid' => Carbon::createFromFormat('Y-m-d', $payment->transaction_date)->format('m/d/Y'),
        //                     'or' => $payment->or_no,
        //                     'principal' => $payment->principal,
        //                     'interest' => $payment->interest,
        //                     'pdi' => $payment->pdi,
        //                     'over' => $payment->over_payment,
        //                     'discount' => null,
        //                     'total_payment' => $payment->amount_applied-$payment->rebates,
        //                     'net_int' => null,
        //                     'vat' => $payment->vat
        //             ];
        //         }
        //     }
        // }

        return $data;
    }
    /* start transaction reports */

    /* start release reports */
    public function releaseReports($filters = [], $category)
    {

        switch ($category) {
            case 'product':

                return $this->getReleaseByProduct($filters);
                break;

            case 'client':

                $type = $filters['type'];
                if ($type == 'all') {
                    unset($filters['type']);
                }

                if ($type == 'new') {
                    $filters['cycle_no'] = 1;
                }

                if ($type == 'center' || $type == 'product' || $type == 'account_officer') {
                    $filters[$type] = $filters['spec'];
                }
                unset($filters['spec']);
                unset($filters['type']);


                return $this->getReleaseByClient($filters, false);
                break;

            case 'account_officer':
                //          $type = $filters['type'];
                // if( $type == 'new' ){
                //              $filters['cycle_no'] = 1;
                //          }
                return $this->getReleaseByAccountOfficer($filters);
                break;

            case 'dst':
                return $this->getReleaseByDST($filters);
                break;

            case 'insurance':
                return $this->releaseInsurance($filters);
                break;

            default:
                # code...
                break;
        }
    }

    public function getReleaseByDST($filters)
    {
        $accounts = $this->getLoanAccounts($filters);
        $branches = Branch::where("status", "active")->get();
        $branchIds = [];
        $branchId2 = [];
        foreach ($branches as $brnch) {
            if (!isset($branchIds[$brnch->branch_code])) {
                $branchIds[$brnch->branch_code] = $brnch->branch_id;
            }
            if (!isset($branchId2[$brnch->branch_id])) {
                $branchId2[$brnch->branch_id] = 0;
            }
        }
        $dstSummary = [];
        foreach ($accounts as $value) {
            if (!isset($dstSummary[$value->terms])) {
                $dstSummary[$value->terms] = [];
                $dstSummary[$value->terms]['branches'] = $branchId2;
                $dstSummary[$value->terms]['amount'] = 0;
            }
            if (!isset($dstSummary[$value->terms]['total_amount'])) {
                $dstSummary[$value->terms]['total_amount'] = 0;
            }
            $dstSummary[$value->terms]['term'] = $value->terms;
            $dstSummary[$value->terms]['branches'][$branchIds[$value->branch_code]] += $value->loan_amount;
            $dstSummary[$value->terms]['total_amount'] += $value->loan_amount;
            $dstSummary[$value->terms]['amount'] += $value->document_stamp;
        }

        return $dstSummary;
    }

    public function getReleaseByAccountOfficer($filters)
    {

        if ($filters['account_officer'] == 'all') {
            $officers = AccountOfficer::where(['status' => 'active'])->get();
        } else {
            $officers = AccountOfficer::where(['status' => 'active', 'ao_id' => $filters['account_officer']])->get();
        }

        // if( $filters['type'] != 'all' ){
        //     $aoId = $filters['type'];
        //     $officers = AccountOfficer::where(['status' => 'active', 'ao_id' => $aoId ])->get()->toArray();
        // }

        $products = Product::where(['status' => 'active'])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);

        $data = [];
        foreach ($officers as $key => $value) {
            $data[$key]['account_officer'] = $value['name'];

            foreach ($products as $k => $v) {

                $data[$key]['products'][$k] = [
                    'reference' => $v['product_code'] . ' - ' . $v['product_name'],
                    'new_account' => 0,
                    'new_account_amount_released' => 0,
                    'repeat_account' => 0,
                    'repeat_account_amount_released' => 0,
                    'total_released' => 0,
                ];

                $accounts = null;
                $filters['product_id'] = $v['product_id'];
                $filters['account_officer'] = $value['ao_id'];

                $accounts = $this->getLoanAccounts($filters);

                if (count($accounts) > 0) {

                    // $data[$key]['products'][$k] = [
                    //     'reference' => $v['product_code'] . ' - ' . $v['product_name'],
                    //     'new_account' => null,
                    //     'new_account_amount_released' => null,
                    //     'repeat_account' => null,
                    //     'repeat_account_amount_released' => null,
                    //     'total_released' => null,
                    // ];

                    //         $v['reference'] = $v['product_code'] . ' - ' . $v['product_name'];
                    //         // $v['repeat_account'] = 0;
                    //         // $v['repeat_account_amount'] = 0;
                    //         // $v['new_account'] = 0;
                    //         // $v['new_account_amount'] = 0;
                    foreach ($accounts as $account) {
                        if ($account->cycle_no > 1) {
                            $data[$key]['products'][$k]['repeat_account'] += 1;
                            $data[$key]['products'][$k]['repeat_account_amount_released'] += $account->loan_amount;
                            //         //         $v['repeat_account'] += 1;
                            //         //         $v['repeat_account_amount'] += $account->loan_amount;
                        } else {
                            $data[$key]['products'][$k]['new_account'] += 1;
                            $data[$key]['products'][$k]['new_account_amount_released'] += $account->loan_amount;
                            //         //          $v['new_account'] += 1;
                            //         //          $v['new_account_amount'] += $account->loan_amount;
                        }

                        $data[$key]['products'][$k]['total_released'] = $data[$key]['products'][$k]['new_account_amount_released'] + $data[$key]['products'][$k]['repeat_account_amount_released'];
                    }
                }

                //     // $officers[$key] = $v;
            }
        }
        return $data;
        // return $filters;
    }

    public function releaseInsurance($filters = [])
    {
        $accounts = $this->getLoanAccounts($filters);
        $insurance = [];
        foreach ($accounts as $key => $value) {
            if (empty($value->insurance)) { continue; }
            $insurance[$key]["account_num"] = $value->account_num;
            $insurance[$key]["name"] = $value->borrower->fullname();
            $insurance[$key]["birthdate"] = $value->borrower->birthdate;
            $insurance[$key]["gender"] = $value->borrower->gender;
            $insurance[$key]["marital_status"] = $value->borrower->status;
            $insurance[$key]["amount_loan"] = $value->loan_amount;
            $insurance[$key]["insurance"] = $value->insurance;
            $insurance[$key]["date_loan"] = $value->date_release;
            $insurance[$key]["due_date"] = $value->due_date;
            $insurance[$key]["term"] = $value->terms;
        }
        return response()->json($insurance);
    }

    /* end release reports */

    /* start repayment report */
    public function repaymentByProduct($filters = [])
    {

        $products = Product::where(['status' => 'active'])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        $paymentTypes = config('enums.payment_type');

        $data = [];

        $memo = [];

        foreach ($products as $key => $value) {

            $data[$key]['reference'] = $value['product_code'] . '-' . $value['product_name'];

            $filters['product_id'] = $value->product_id;

            $payments = $this->getPayments($filters);

            if (count($payments)) {

                foreach ($payments as $k => $payment) {

                    foreach ($paymentTypes as $type) {

                        if ($payment->payment_type == $type) {

                            if (!isset($data[$key]['payment'][$type])) {
                                $data[$key]['payment'][$type] = [
                                    'principal' => 0,
                                    'interest' => 0,
                                    'pdi' => 0,
                                    'over' => 0,
                                    'discount' => 0,
                                    'total_payment' => 0,
                                    'net_int' => 0,
                                    'vat' => 0,
                                ];
                            }

                            $data[$key]['payment'][$type]['principal'] += $payment->principal;
                            $data[$key]['payment'][$type]['interest'] += $payment->interest;
                            $data[$key]['payment'][$type]['pdi'] += ($payment->pdi_approval_no) ? 0 : $payment->pdi;
                            $data[$key]['payment'][$type]['over'] += $payment->over_payment;
                            $data[$key]['payment'][$type]['discount'] += $payment->rebates;
                            $data[$key]['payment'][$type]['total_payment'] += $payment->amount_applied - $payment->rebates;
                            $data[$key]['payment'][$type]['net_int'] += $payment->interest;
                            $data[$key]['payment'][$type]['vat'] += $payment->vat;
                            if ($payment->memo_type) {
                                if (!isset($data[$key]['payment'][$type]["memo"][$payment->memo_type])) {
                                    $data[$key]['payment'][$type]["memo"][$payment->memo_type] = 0;
                                }
                                $data[$key]['payment'][$type]["memo"][$payment->memo_type] += $payment->amount_applied - $payment->rebates;
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function repaymentByClient($filters = [])
    {

        if ($filters["type"] == 'center' || $filters["type"] == 'product' || $filters["type"] == 'account_officer' || $filters["type"] == 'payment_status') {
            $filters[$filters["type"]] = $filters['spec'];
        }
        $payments = $this->getPayments($filters);
        $data = [];
        foreach ($payments as $payment) {

            $data[] = [
                /* 'borrower' => Borrower::find($payment->account->borrower_id)->fullname(), */
                'borrower' => Borrower::find($payment->borrower_id)->fullname(),
                'payment_date' => $payment->transaction_date,
                'due_date' => $payment->due_date,
                'or' => $payment->or_no,
                'principal' => $payment->principal,
                'interest' => $payment->interest + $payment->rebates,
                'pdi' => ($payment->pdi_approval_no) ? 0 : $payment->pdi,
                'overpayment' => $payment->over_payment,
                'rebates' => $payment->rebates,
                'total' => $payment->amount_applied - $payment->rebates,
                'net_interest' => $payment->interest,
                'net_pdi' => ($payment->pdi_approval_no) ? 0 : $payment->pdi,
                'vat' => $payment->vat,
                'payment_type' => $payment->payment_type,
                'memo_type' => $payment->memo_type,
                'amortization_interest' => $payment->amortization_interest,
                'amortization_principal' => $payment->amortization_principal,
                'amortization_id' => $payment->id
            ];
        }

        return collect($data)->sortBy([
            ['borrower', 'asc'],
            ['payment_date', 'asc'],
            ['or', 'asc']
        ])->values();
    }
    /* end repayment report */

    public function repaymentByAccountOfficer($filters = []) {}

    public function branchCollectionReport($filters = [])
    {

        $branch = Branch::find($filters['branch_id']);

        $accounts = LoanAccount::join('center', 'center.center_id', '=', 'loan_accounts.center_id')
            ->select('loan_accounts.*', 'center.*', 'loan_accounts.payment_mode');


        if (isset($filters['account_officer']) && $filters['account_officer']) {
            $accounts->where(['loan_accounts.ao_id' => $filters['account_officer']]);
        }

        if (isset($filters['center']) && $filters['center']) {
            $accounts->where(['loan_accounts.center_id' => $filters['center']]);
        }

        $accounts->where(['loan_accounts.status' => LoanAccount::STATUS_RELEASED]);
        $accounts->where(['loan_accounts.branch_code' => $branch->branch_code]);
        $accounts->whereIn('loan_accounts.loan_status', [LoanAccount::LOAN_ONGOING, 'Past Due']);

        $accounts = $accounts->get();

        $data = [];

        if (count($accounts) > 0) {

            foreach ($accounts as $key => $value) {

                $loanAccount = LoanAccount::find($value['loan_account_id']);
                $currentAmortization = $loanAccount->getCurrentAmortization();

                $borrower = Borrower::find($value['borrower_id']);
                $data[$key]['center'] = $value->center_id;
                $data[$key]['account_officer'] = $value->ao_id;
                $data[$key]['client'] = $borrower->fullname();
                $data[$key]['date_loan'] = $value['date_release'];
                $data[$key]['maturity_date'] = $value['due_date'];
                $data[$key]['amount_loan'] = $value['loan_amount'];
                $data[$key]['outstanding_balance'] = $loanAccount->remainingBalance()["memo"]["balance"];
                $data[$key]['principal_balance'] = $loanAccount->remainingBalance()["principal"]["balance"];
                $data[$key]['delinquent'] = LoanAccount::getPaymentStatus($loanAccount->loan_account_id) === 'Delinquent' ? max (0,($currentAmortization['delinquent']['principal'] + $currentAmortization['delinquent']['interest']) - ($currentAmortization['advance_principal'] + $currentAmortization['advance_interest']))  : 0;
                $data[$key]['penalty'] = ($currentAmortization?->penalty ?? 0) + ($currentAmortization?->pdi ?? 0);
                
                $principalPart = max(0,($currentAmortization['principal'] ?? 0) + ($currentAmortization['short_principal'] ?? 0) - ($currentAmortization['advance_principal'] ?? 0));
                $interestPart = max(0,($currentAmortization['interest'] ?? 0) + ($currentAmortization['short_interest'] ?? 0) - ($currentAmortization['advance_interest'] ?? 0));
                $data[$key]['amount_due'] = $principalPart + $interestPart;

                $data[$key]['contact'] = $borrower->contact_number;
                $data[$key]['address'] = $borrower->address;

                // Check payment_mode condition and set weekly_amortization
                if ($value->payment_mode === 'Lumpsum') {
                    $data[$key]['weekly_amortization'] = $value->loan_amount;
                } else {
                    $data[$key]['weekly_amortization'] = $value->amortization()['total'];
                }
            }
            $data = collect($data)->sortBy(function ($item) {
                // Sort by client name first (ascending)
                $clientName = $item['client'];

                // Sort by date_loan second (ascending)
                $dateLoan = $item['date_loan'];

                return [
                    $clientName,  // Sorting by client name first
                    $dateLoan     // Sorting by loan date second
                ];
            })->values();
        }
        return $d = [

            'name' =>  '',
            'data' => $data,

        ];
    }

    public function branchMaturityReport($filters = [])
    {
        $matureLoans = [];
        $loanAccounts = $this->getLoanAccounts($filters);
        foreach ($loanAccounts as $key => $value) {
            if ($value->loan_status != LoanAccount::PAYMENT_PAID) {
                array_push($matureLoans, [
                    'loan_account_id' => $value->loan_account_id,
                    'loan_account_num' => $value->loan_account_num,
                    'client' => $value->borrower->fullname(),
                    'date_released' => $value->date_release,
                    'due_date' => $value->due_date,
                    'principal_balance' => $value->remainingBalance()["principal"]["balance"],
                    'interest_balance' => $value->remainingBalance()["interest"]["balance"] - $value->remainingBalance()["rebates"]["credit"],
                    'center' => $value->center_id ? $value->center->center : ''
                ]);
            }

            /* $matureLoans[$key]["loan_account_id"] = $value->loan_account_id;
            $matureLoans[$key]["loan_account_num"] = $value->account_num;
            $matureLoans[$key]["client"] = $value->borrower->fullname();
            $matureLoans[$key]["date_released"] = $value->date_release;
            $matureLoans[$key]["due_date"] = $value->due_date;
            // $matureLoans[$key]["balance"] = $value->remainingBalance();
            $matureLoans[$key]["principal_balance"] = $value->remainingBalance()["principal"]["balance"];
            $matureLoans[$key]["interest_balance"] = $value->remainingBalance()["interest"]["balance"] - $value->remainingBalance()["rebates"]["credit"];
            $matureLoans[$key]["center"] = $value->center_id ? $value->center->center : ''; */
        }
        return $matureLoans;
    }

    public function clientPaymentStatus($filters = [])
    {
        $data = [
            "ongoing" => [],
            "closed" => []
        ];
        $closedLoanAccounts = Loanaccount::where(['loan_accounts.status' => 'released', "borrower_id" => $filters["borrower_id"], "loan_accounts.loan_status" => LoanAccount::LOAN_PAID])->get();
        $ongoingLoanAccounts = Loanaccount::where(['loan_accounts.status' => 'released', "borrower_id" => $filters["borrower_id"]])->where("loan_accounts.loan_status", "!=", LoanAccount::LOAN_PAID)->get();
        foreach ($closedLoanAccounts as $closedKey => $account) {
            $amort = $account->amortizationStatusReport($filters["as_of"]);
            $maxLate = 0;
            $paidAmort = 0;
            foreach ($amort as $key => $value) {
                $maxLate = $maxLate < $value["days_late"] ? $value["days_late"] : $maxLate;
                $paidAmort += in_array($value['amor_status'], ["Paid", "Paid Late"]) ? 1 : 0;
            }
            $tempData = [
                "cumulative_loan" => $account->cycle_no,
                "account_num" => $account->account_num,
                "date_loaned" => $account->date_release,
                "amt_loan" => $account->loan_amount,
                "no_of_amort" => $account->no_of_installment,
                "max_late" => $maxLate,
                "business_activity" => 0
            ];
            $data["closed"][] = $tempData;
        }
        foreach ($ongoingLoanAccounts as $ongoingKey => $account) {
            $amort = $account->amortizationStatusReport($filters["as_of"]);
            $maxLate = 0;
            $paidAmort = 0;
            $expected_todate = 0;
            foreach ($amort as $key => $value) {
                $maxLate = $maxLate < $value["days_late"] ? $value["days_late"] : $maxLate;
                $paidAmort += in_array($value['amor_status'], ["Paid"]) ? 1 : 0;
                $expected_todate += $value['amor_status'] != 'Approaching' ? 1 : 0;
            }
            $tempData = [
                "cumulative_loan" => $account->cycle_no,
                "account_num" => $account->account_num,
                "date_loaned" => $account->date_release,
                "amt_loan" => $account->loan_amount,
                "no_of_amort" => $account->no_of_installment,
                "max_late" => $maxLate,
                "expected_todate" => $expected_todate,
                "amort_ontime" => $paidAmort,
                "ontime_percentage" => $expected_todate == 0 ? 0 : round((($paidAmort / $expected_todate) * 100), 2),
                "business_activity" => 0,
                "amortizations" => $amort
            ];
            $data["ongoing"][] = $tempData;
        }
        return $data;
    }

    public function branchAOReport($filters = [])
    {
        $tranDate = new EndTransaction();
        $branch = Branch::find($filters['branch_id']);
        $data = [];
        if ($filters["group"] == Reports::BRANCH_AO_PERFORMANCE) {
            $data = LoanReports::getAccountOfficerReport($filters["as_of"], $filters['branch_id']);
            // $accOfficers = NULL;
            // $transDate = new EndTransaction();
            // $transactionDateNow = $transDate->getTransactionDate($filters['branch_id'])->date_end;

            // if (isset($filters["branch_id"]) && $filters["branch_id"]) {


            //     $accOfficers =  AccountOfficer::join('account_officer_branch', 'account_officer.ao_id', '=', 'account_officer_branch.ao_id')
            //         ->join('branch', 'account_officer_branch.branch_id', '=', 'branch.branch_id')
            //         ->where([
            //             'account_officer.status' => AccountOfficer::STATUS_ACTIVE,
            //             'branch.branch_id' => $filters['branch_id']
            //         ])->select('account_officer.ao_id', 'account_officer.name')
            //         ->without('branch', 'branch_registered')
            //         ->orderBy('account_officer.name', 'ASC')
            //         ->groupBy('account_officer.ao_id')
            //         ->get()
            //         ->toArray();
            // } else {

            //     $accOfficers = AccountOfficer::where(["status" => AccountOfficer::STATUS_ACTIVE])
            //         ->select('account_officer.ao_id', 'account_officer.name')
            //         ->without('branch', 'branch_registered')
            //         ->orderBy('account_officer.name', 'ASC')
            //         ->groupBy('account_officer.ao_id')
            //         ->get()
            //         ->toArray();
            // }

            // $products = Product::where(["status" => Product::STATUS_ACTIVE])
            //     ->select('product_id', 'product_code', 'product_name')
            //     ->get()
            //     ->toArray();
            // foreach ($accOfficers as $aoKey => $aoValue) {
            //     foreach ($products as $prodKey => $prodValue) {
            //         $tempProd = $prodValue;

            //         $allAOProd = LoanAccount::where([
            //             "status" => LoanAccount::STATUS_RELEASED,
            //             "ao_id" => $aoValue["ao_id"],
            //             "product_id" => $prodValue["product_id"],
            //             "branch_code" => $branch->branch_code
            //         ])
            //             ->whereIn('loan_status', [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE, LoanAccount::LOAN_RESTRUCTED, LoanAccount::LOAN_RES_WO_PDI])
            //             ->without(['documents', 'borrower', 'center', 'branch', 'product', 'accountOfficer', 'payments'])
            //             ->get();


            //         if (count($allAOProd) > 0) {
            //             $tempProd["all"] = ["count" => 0, "amount" => 0];
            //             $tempProd["delinquent"] = ["count" => 0, "amount" => 0, "rate" => 0];
            //             $tempProd["pastdue"] = ["count" => 0, "amount" => 0, "rate" => 0];

            //             foreach ($allAOProd as $key => $value) {
            //                 $remainBal = $value->remainingBalance();

            //                 $principalBalance = $remainBal["principal"]["balance"];
            //                 $memoBal = $remainBal["memo"]["balance"];
            //                 $currentAmort = $this->getCurrentAmortization($value->getCurrentAmortization(), $remainBal);


            //                 $totalBal = $memoBal < 0 ? 0 : $memoBal;

            //                 if ($value->loan_status == LoanAccount::LOAN_RES_WO_PDI && $totalBal == 0 || $value->loan_status == LoanAccount::LOAN_RESTRUCTED && $totalBal == 0) {
            //                     continue;
            //                 } else {
            //                     $tempProd["all"]["count"] += 1;
            //                     $tempProd["all"]["amount"] += $principalBalance;
            //                     if ($value->loan_status == LoanAccount::LOAN_ONGOING) {

            //                         if ($value->payment_status == LoanAccount::PAYMENT_DELINQUENT) {
            //                             $tempProd["delinquent"]["count"] += 1;

            //                             if ($currentAmort) {
            //                                 $tempProd["delinquent"]["amount"] += $currentAmort["amount_due"] > 0 ? $currentAmort["amount_due"] : 0;
            //                             }

            //                             // $tempProd["delinquent"]["account"] = $amortization;
            //                             // break;
            //                         }
            //                     } else {
            //                         $tempProd["pastdue"]["count"] += 1;
            //                         $tempProd["pastdue"]["amount"] += $principalBalance;
            //                     }
            //                 }
            //             }
            //             if ($tempProd["all"]["count"] == 0) {
            //                 continue;
            //             } else {
            //                 $tempProd["delinquent"]["rate"] = $tempProd["all"]["amount"] == 0 ? 0 :  round((($tempProd["delinquent"]["amount"] / $tempProd["all"]["amount"]) * 100), 2); //round((($tempProd["delinquent"]["amount"] / $tempProd["all"]["amount"])*100));
            //                 $tempProd["pastdue"]["rate"] = $tempProd["all"]["amount"] == 0 ? 0 : round((($tempProd["pastdue"]["amount"] / $tempProd["all"]["amount"]) * 100), 2); //round((($tempProd["delinquent"]["amount"] / $tempProd["all"]["amount"])*100));
            //                 $accOfficers[$aoKey]["products"][] = $tempProd;
            //             }
            //         }
            //     }
            // }
            // $data = $accOfficers;
        } else if ($filters["group"] == Reports::BRANCH_AO_WRITEOFF) {
            $writeoffAccounts = [];
            $accOfficers = AccountOfficer::where(["status" => AccountOfficer::STATUS_ACTIVE]);
            if (isset($filters["branch_id"]) && $filters["branch_id"]) {
                $accOfficers = $accOfficers->where(["branch_id" => $filters["branch_id"]]);
            }
            if (isset($filters["account_officer"]) && $filters["account_officer"]) {
                $accOfficers = $accOfficers->where(["ao_id" => $filters["account_officer"]]);
            }
            $accOfficers = $accOfficers->get()->toArray();
            foreach ($accOfficers as $aoKey => $aoValue) {
                $filtersCopy = $filters;
                $filtersCopy["loan_status"] = LoanAccount::LOAN_WRITEOFF;
                $filtersCopy["account_officer"] = $aoValue["ao_id"];
                $accounts = $this->getLoanAccounts($filtersCopy);
                $tempData = [
                    "ao_id" => $aoValue["ao_id"],
                    "ao_name" =>  $aoValue['name'],
                    "num_of_accounts" => 0,
                    "principal_balance" => 0,
                    /* "pastdue" => 0,
                    "pd_rate" => 100, */
                    "interest_balance" => 0,

                ];
                foreach ($accounts as $accKey => $account) {
                    $rBalance = $account->remainingBalance();
                    $tempData["num_of_accounts"] += 1;
                    $tempData["principal_balance"] += $rBalance["principal"]["balance"];
                    /* $tempData["pastdue"] += $account->remainingBalance()["principal"]["balance"]; */
                    $tempData["interest_balance"] += $rBalance["interest"]["balance"];
                }
                $writeoffAccounts[] = $tempData;
            }
            $data = $writeoffAccounts;
        } else if ($filters["group"] == Reports::BRANCH_AO_DELINQUENT) {
            $accOfficers = AccountOfficer::where(["status" => AccountOfficer::STATUS_ACTIVE]);
            if (isset($filters["branch_id"]) && $filters["branch_id"]) {
                $accOfficers = $accOfficers->where(["branch_id" => $filters["branch_id"]]);
            }
            if (isset($filters["account_officer"]) && $filters["account_officer"]) {
                $accOfficers = $accOfficers->where(["ao_id" => $filters["account_officer"]]);
            }
            $accOfficers = $accOfficers->get()->toArray();
            $centers = Center::where(["status" => "active"])
                ->get()->toArray();
            $centers[] = null;
            foreach ($accOfficers as $aoKey => $value) {
                $accOfficers[$aoKey]["data"] = [];
                foreach ($centers as $centKey => $centVal) {
                    $filtersCopy = $filters;
                    $filtersCopy["payment_status"] = "delinquent";
                    $filtersCopy["account_officer"] = $aoKey;
                    $centerName = $centVal ? $centVal["center"] : "No Center";
                    if ($centerName != "No Center") {
                        $filtersCopy["center"] = $centVal["center_id"];
                    } else {
                        $filtersCopy["center"] = $centerName;
                    }
                    $accounts = $this->getLoanAccounts($filtersCopy);
                    foreach ($accounts as $accKey => $account) {



                        $transactionDate = $tranDate->getTransactionDate($account->branch->branch_id)->date_end;
                        $accOfficers[$aoKey]["data"][$centerName] = [
                            "borrower_name" => $account->borrower->fullname(),
                            "account_num" => $account->account_num,
                            "date_loan" => $account->date_release,
                            "maturity" => $account->due_date,
                            "amount_loan" => $account->loan_amount,
                            "balance" => $account->outstandingBalance($account->loan_account_id),
                            "principal_balance" => $account->remainingBalance()["principal"]["balance"],
                            "interest_balance" => $account->remainingBalance()["interest"]["balance"] - $account->remainingBalance()["rebates"]["credit"],
                            "amortization" => $account->amortization()["principal"] + $account->amortization()["interest"],
                            "delinquent_amount" => $account->outstandingBalance($account->loan_account_id),
                            "type" => $account->payment_mode,
                            "missed_amortization" => $account->getCurrentAmortization()['delinquent'] ? sizeof($account->getCurrentAmortization()['delinquent']['missed']) : 0,
                            "days_missed" => $account->getCurrentAmortization()['delinquent'] ? $account->daysMissed($account->getCurrentAmortization()['delinquent']['missed'], $transactionDate, true) : 0,
                            "status" => $account->payment_status
                        ];
                    }
                }
            }
            $data = $accOfficers;
        }
        return $data;
    }


    private function getCurrentAmortization($currentAmort, $remainBal)
    {
        $amortization = null;
        if ($currentAmort) {
            $amortization = [
                'current_principal'         =>      $currentAmort["principal"],
                'adv_principal'             =>      $currentAmort["advance_principal"],
                'short_principal'           =>      $currentAmort["short_principal"],
                'amort_interest'            =>      $currentAmort["interest"],
                'adv_interest'              =>      $currentAmort["advance_interest"],
                'short_interest'            =>      $currentAmort["short_interest"],
                'amount_due'                =>      ceil(($currentAmort["principal"] + $currentAmort["short_principal"] - $currentAmort["advance_principal"]) + ($currentAmort["interest"] + $currentAmort["short_interest"] - $currentAmort["advance_interest"]) + ($remainBal["pdi"]["balance"] + $remainBal["rebates"]["balance"]))
            ];
        }

        return $amortization;
    }

    public function setLoanAccountsByFilter($filters = [])
    {
        $accounts = $this->getLoanAccounts($filters);
    }

    public function branchLoanListingReport($filters = [])
    {
        /* $accOfficers = AccountOfficer::where(["status"=> AccountOfficer::STATUS_ACTIVE]); */
        $accOfficers =  AccountOfficer::join('account_officer_branch', 'account_officer.ao_id', '=', 'account_officer_branch.ao_id')
            ->join('branch', 'account_officer_branch.branch_id', '=', 'branch.branch_id')
            ->where([
                'account_officer.status' => AccountOfficer::STATUS_ACTIVE,
            ]);
        if (isset($filters["branch_id"]) && $filters["branch_id"]) {
            $accOfficers = $accOfficers->where(["branch.branch_id" => $filters["branch_id"]]);
        }
        if (isset($filters["account_officer"]) && $filters["account_officer"]) {
            $accOfficers = $accOfficers->where(["account_officer.ao_id" => $filters["account_officer"]]);
        }
        $accOfficers = $accOfficers->without('branch', 'branch_registered')->select('account_officer.ao_id', 'account_officer.name')->get()->toArray();
        $centers = Center::where(["status" => "active"]);
        if (isset($filters["center"]) && $filters["center"]) {
            $centers = $centers->where(["center_id" => $filters["center"]]);
            $centers = $centers->select('center_id', 'center')->get()->toArray();
        } else {
            $centers = $centers->select('center_id', 'center')->get()->toArray();
            $centers[] = ["center" => "No Center", "center_id" => "No Center"];
        }
        $products = Product::where(["status" => "active"]);
        if (isset($filters["product"]) && $filters["product"]) {
            $products = $products->where(["product_id" => $filters["product"]]);
        }
        $products = $products->select('product_id', 'product_code', 'product_name')->get()->toArray();

        // $accounts = $this->getLoanAccounts($filters);
        foreach ($accOfficers as $aoKey => $aoValue) {
            foreach ($products as $prodKey => $prodValue) {
                $accOfficers[$aoKey]["products"][$prodValue["product_name"]] = $prodValue;
                foreach ($centers as $centKey => $centVal) {
                    // $accOfficers[$aoKey]["products"][$prodValue["product_name"]]["centers"][$centVal["center"]] = $centVal;

                    $accounts = $this->getLoanAccounts([
                        'account_officer' => $aoValue["ao_id"],
                        'product' => $prodValue["product_id"],
                        'center' => $centVal["center_id"],
                        'branch_id' => $filters["branch_id"],
                        'loan_status' => $filters["loan_status"],
                        'report' => $filters["report"]
                    ]);

                    if (count($accounts) > 0) {
                        foreach ($accounts as $key => $account) {
                            $totalBal = $account->outstandingBalance($account->loan_account_id);
                            $oBalance = $totalBal < 0 ? 0 : $totalBal;
                            $remainingBal = $account->remainingBalance();
                            $reb = $remainingBal['rebates']['credit'];
                            $interestBal = $remainingBal['interest']['balance'];
                            $principalBal = $remainingBal['principal']['balance'];
                            $amortization = $account->amortization();
                            $current_amort = $account->getCurrentAmortization();


                            if ($account->loan_status == LoanAccount::LOAN_RES_WO_PDI && $oBalance == 0 || $account->loan_status == LoanAccount::LOAN_RESTRUCTED && $oBalance == 0) {
                                continue;
                            } else {
                                $amountDue = 0;
                                $amortPrincipal = 0;
                                $advPrincipal = 0;
                                $shortPrincipal = 0;
                                $amortInterest = 0;
                                $advInterest = 0;
                                $shortInterest = 0;

                                if ($current_amort) {
                                    $amortPrincipal = $current_amort["principal"];
                                    $advPrincipal = $current_amort["advance_principal"];
                                    $shortPrincipal = $current_amort["short_principal"];
                                    $amortInterest = $current_amort["interest"];
                                    $advInterest = $current_amort["advance_interest"];
                                    $shortInterest = $current_amort["short_interest"];
                                    $amountDue = floatval(($amortPrincipal + $shortPrincipal - $advPrincipal) + ($amortInterest + $shortInterest - $advInterest) + ($remainingBal["rebates"]["balance"]));
                                }

                                $principal = $amortization['principal'];
                                $interest = $amortization['interest'];



                                $accOfficers[$aoKey]["products"][$prodValue["product_name"]]["centers"][$centVal["center"]]['accounts'][] = [
                                    'borrower_name' => isset($account->borrower) ? $account->borrower->fullname() : '',
                                    "account_num" => $account->account_num,
                                    "date_loan" => Carbon::createFromFormat('Y-m-d', $account->date_release)->format('m/d/Y'),
                                    "maturity" => Carbon::createFromFormat('Y-m-d', $account->due_date)->format('m/d/Y'),
                                    "amount_loan" => $account->loan_amount,
                                    "loan_interest" => $account->interest_amount,
                                    "principal_amount" => abs(($amortPrincipal + $shortPrincipal) - $advPrincipal),
                                    "interest_amount" => abs($amortInterest + $shortInterest - $advInterest),
                                    "amount_due" => $amountDue > 0 ? $amountDue : 0,
                                    "distribution" => [
                                        'principal' => $amortPrincipal,
                                        'short_principal' => $shortPrincipal,
                                        'advance_principal' => $advPrincipal,
                                        'interest' => $amortInterest,
                                        'short_interest' => $shortInterest,
                                        'advance_interest' => $advInterest,
                                        'pdi' => $remainingBal["pdi"]["balance"],
                                        'rebates' => $remainingBal["rebates"]["balance"]
                                    ],
                                    "principal_balance" => $principalBal,
                                    "interest_balance" => $interestBal - $reb,
                                    "outstanding_balance" => $oBalance,
                                    "amortization" => $principal + $interest, //$account->amortization()["principal"] + $account->amortization()["interest"],
                                    "amort_dist" => ['principal' => $principal, 'interest' => $interest],
                                    // "current_amort" => $current_amort,
                                    "type" => $account->payment_mode,
                                    "loan_status" => $account->loan_status,
                                    "status" => $account->payment_status,
                                ];

                                $acc = $accOfficers[$aoKey]["products"][$prodValue["product_name"]]["centers"][$centVal["center"]]['accounts'];
                                usort($acc, function ($a, $b) {
                                    return strcmp($a['borrower_name'], $b['borrower_name']);
                                });

                                $accOfficers[$aoKey]["products"][$prodValue["product_name"]]["centers"][$centVal["center"]]['accounts'] = $acc;
                            }
                        }
                    }
                }
            }
        }

        return $accOfficers;
    }

    public function aoRevenueReport($filters = [])
    {
        $accOfficers = AccountOfficer::where(["status" => AccountOfficer::STATUS_ACTIVE]);
        if (isset($filters["branch_id"]) && $filters["branch_id"]) {
            $accOfficers = $accOfficers->where(["branch_id" => $filters["branch_id"]]);
        }
        $accOfficers = $accOfficers->get()->toArray();
        $report = [];
        foreach ($accOfficers as $aoValue) {
            $loanAccounts = $this->getLoanAccounts(["account_officer" => $aoValue['ao_id']]);
            $outstanding_loan_portfolio = 0;
            $filing_fee = 0;
            $interest_income = 0;
            $penalty = 0;
            $pdi = 0;
            foreach ($loanAccounts as $loanAccount) {
                $outstanding_loan_portfolio += $loanAccount->remainingBalance()['principal']['balance'];
            }
            $loanAccountsDate = $this->getLoanAccounts(array_merge($filters, ["account_officer" => $aoValue['ao_id']]));
            foreach ($loanAccountsDate as $loanAccount) {
                $filing_fee += $loanAccount->filing_fee;
            }
            $payments = $this->getPayments(array_merge($filters, ["account_officer" => $aoValue['ao_id']]));
            foreach ($payments as $payment) {
                $interest_income += $payment->interest;
                $penalty += $payment->penalty_approval_no ? 0 : $payment->penalty;
                $pdi += $payment->pdi_approval_no ? 0 : $payment->pdi;
            }
            $report[] = [
                "account_officer" => $aoValue['name'],
                "outstanding_loan_portfolio" => $outstanding_loan_portfolio,
                "filing_fee" => $filing_fee,
                "interest_income" => $interest_income,
                "penalty" => $penalty,
                "pdi" => $pdi
            ];
        }
        return $report;
    }

    public function loanAgingReport($filters = [])
    {
        $loanAccounts = $this->getLoanAccounts($filters);
        $data = [];
        foreach ($loanAccounts as $loanAccount) {
            if ($loanAccount->loan_status == LoanAccount::LOAN_PAID) {
                continue;
            }
            $curAmort = $loanAccount->getCurrentAmortization();
            $remBal = $loanAccount->remainingBalance();
            $dueAmt = $curAmort->short_principal + $curAmort->principal + $curAmort->interest + $curAmort->short_interest;
            $bal = $remBal["memo"]["balance"];
            $late = $loanAccount->daysMissed($loanAccount->getCurrentAmortization()['delinquent']['missed'], $filters['as_of'], true);
            if ($loanAccount->loan_status == LoanAccount::LOAN_ONGOING && $loanAccount->payment_status != LoanAccount::PAYMENT_DELINQUENT) {
                // Here for Current Accounts
                if (!isset($data["current"])) {
                    $data["current"] = [
                        "num_accts" => 0,
                        "loan_amt" => 0,
                        "balance" => 0,
                        "due_amt" => 0
                    ];
                }
                $data["current"]["num_accts"] += 1;
                $data["current"]["loan_amt"] += $loanAccount->loan_amount;
                $data["current"]["balance"] += $bal;
                $data["current"]["due_amt"] += $dueAmt;
            } else if ($loanAccount->loan_status == LoanAccount::LOAN_ONGOING && $loanAccount->payment_status == LoanAccount::PAYMENT_DELINQUENT) {
                // Here for Delinquent Accounts
                if (!isset($data["delinquent"])) {
                    $data["delinquent"] = [
                        "1 to 30" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "31 to 60" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "61 to 90" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "91 to 180" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "180 above" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                    ];
                }
                $day = "";
                if ($late >= 1 && $late <= 30) {
                    $day = "1 to 30";
                } else if ($late >= 31 && $late <= 60) {
                    $day = "31 to 60";
                } else if ($late >= 61 && $late <= 90) {
                    $day = "61 to 90";
                } else if ($late >= 91 && $late <= 180) {
                    $day = "91 to 180";
                } else if ($late > 180) {
                    $day = "180 above";
                }
                $data["delinquent"][$day]["num_accts"] += 1;
                $data["delinquent"][$day]["loan_amt"] += $loanAccount->loan_amount;
                $data["delinquent"][$day]["balance"] += $bal;
                $data["delinquent"][$day]["due_amt"] += $dueAmt;
            } else {
                // Here for other Statuses
                if (!isset($data[$loanAccount->loan_status])) {
                    $data[$loanAccount->loan_status] = [
                        "1 to 30" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "31 to 60" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "61 to 90" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "91 to 180" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                        "180 above" => [
                            "num_accts" => 0,
                            "loan_amt" => 0,
                            "balance" => 0,
                            "due_amt" => 0
                        ],
                    ];
                }
                $day = "";
                if ($late >= 1 && $late <= 30) {
                    $day = "1 to 30";
                } else if ($late >= 31 && $late <= 60) {
                    $day = "31 to 60";
                } else if ($late >= 61 && $late <= 90) {
                    $day = "61 to 90";
                } else if ($late >= 91 && $late <= 180) {
                    $day = "91 to 180";
                } else if ($late > 180) {
                    $day = "180 above";
                } else {
                    continue;
                }
                $data[$loanAccount->loan_status][$day]["num_accts"] += 1;
                $data[$loanAccount->loan_status][$day]["loan_amt"] += $loanAccount->loan_amount;
                $data[$loanAccount->loan_status][$day]["balance"] += $bal;
                $data[$loanAccount->loan_status][$day]["due_amt"] += $dueAmt;
            }
        }
        return $data;
    }

    public function cancelledRepaymentByClient($filters = [])
    {

        $payments = Payment::join('loan_accounts', 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
            ->where(['payment.branch_id' => $filters['branch_id'], 'payment.status' => 'cancelled'])
            ->whereDate('payment.cancelled_date', '>=', $filters['date_from'])
            ->whereDate('payment.cancelled_date', '<=', $filters['date_to'])
            ->orderBy('payment.transaction_date', 'ASC')
            ->get([
                'payment.*',
                'loan_accounts.borrower_id',
                'loan_accounts.account_num',
            ]);

        $data = [];

        foreach ($payments as $payment) {

            $data[] = [
                'date_cancelled' => Carbon::createFromFormat('Y-m-d', $payment->cancelled_date)->format('m/d/Y'),
                'cancelled_by' => $payment->cancelled_by ? User::find($payment->cancelled_by)->fullname() : "N/A",
                'account_num' => $payment->account_num,
                'borrower' => Borrower::find($payment->borrower_id)->fullname(),
                'payment_date' => Carbon::createFromFormat('Y-m-d', $payment->transaction_date)->format('m/d/Y'),
                'or' => $payment->or_no,
                'transaction_number' => $payment->transaction_number,
                'principal' => $payment->principal,
                'interest' => $payment->interest,
                'pdi' => ($payment->pdi_approval_no) ? $payment->pdi : 0,
                'pdi_waive' => ($payment->pdi_approval_no) ? 0 : $payment->pdi,
                'penalty' => ($payment->penalty_approval_no) ? $payment->penalty : 0,
                'penalty_waive' => ($payment->penalty_approval_no) ? 0 : $payment->penalty,
                'rebates' => $payment->rebates,
                'overpayment' => $payment->over_payment,
                'total' => $payment->amount_applied - $payment->rebates,
                'remarks' => $payment->remarks,
                'payment_type' => $payment->payment_type
            ];
        }

        return $data;
    }

    public function microGroup($filters = [], $weeksAndDays, $monthStart, $monthEnd)
    {
        $data = ["monday" => [], "tuesday" => [], "wednesday" => [], "thursday" => [], "friday" => []];
        foreach ($data as $weekDay => $weekDayData) {
            //get centers where center.day_sched
            $centers = Center::where(["center.day_sched" => $weekDay, "status" => "active"]) // center daysched  or use center sched in loan account?
                ->orderBy('center.center')->get();
            foreach ($centers as $centerId => $centerVal) {
                $data[$weekDay][$centerVal->center]["all"]["account_officer"]  = "test_data_api_result_ACCOUNT_OFFICER";
                $data[$weekDay][$centerVal->center]["all"]["area_of_operation"]  = $centerVal->area;
                $no_of_clients = LoanAccount::join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->join("branch", "branch.branch_code", "loan_accounts.branch_code")
                    ->whereIn(
                        "loan_accounts.loan_status",
                        [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE]
                    )
                    ->where(["loan_accounts.center_id" => $centerVal->center_id, "product.product_name" => 'micro group', "branch.branch_id" => $filters["branch_id"]])
                    ->groupBy("loan_accounts.center_id")
                    ->select([
                        DB::raw("ifnull(count(loan_accounts.loan_account_id),0) as no_of_clients"),
                        DB::raw("COUNT(CASE WHEN loan_status = 'Past Due' THEN 1 ELSE null END) as pastdue_count"),
                        DB::raw("COUNT(CASE WHEN payment_status = 'Current' AND loan_status = 'Ongoing' THEN 1 ELSE null END) as current_count")
                    ])
                    ->first();
                $data[$weekDay][$centerVal->center]["all"]['no_of_clients'] = $no_of_clients ? $no_of_clients->no_of_clients : 0;
                $data[$weekDay][$centerVal->center]["all"]['no_of_pastdue'] = $no_of_clients ? $no_of_clients->pastdue_count : 0;
                $data[$weekDay][$centerVal->center]["all"]['no_of_current'] = $no_of_clients ? $no_of_clients->current_count : 0;
                $data[$weekDay][$centerVal->center]["all"]["start"] = $monthStart;
                $data[$weekDay][$centerVal->center]["all"]["end"] = $monthEnd;
                $monthPayments = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                    ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->join("branch", "branch.branch_code", "loan_accounts.branch_code")
                    ->where(["loan_accounts.center_id" => $centerVal->center_id, "product.product_name" => 'micro group', "branch.branch_id" => $filters["branch_id"]])
                    ->whereDate('payment.transaction_date', '>=', $monthStart)
                    ->whereDate('payment.transaction_date', '<=', $monthEnd)
                    ->groupBy("loan_accounts.loan_account_id")
                    ->select(["loan_accounts.loan_account_id", DB::raw("sum(payment.amount_applied-payment.rebates) as total_paid")])
                    ->get();
                $data[$weekDay][$centerVal->center]["all"]["month_payments"] = $monthPayments;
                $data[$weekDay][$centerVal->center]["all"]["num_of_payments"] = 0;
                $data[$weekDay][$centerVal->center]["all"]["total_paid"] = 0;
                foreach ($monthPayments as $key => $value) {
                    $data[$weekDay][$centerVal->center]["all"]["num_of_payments"] += 1;
                    $data[$weekDay][$centerVal->center]["all"]["total_paid"] += $value->total_paid;
                }
                foreach ($weeksAndDays as $week => $weekData) {
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week] = ["num_of_payments" => 0, "total_paid" => 0];
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week]["start"] = $weekData['start'];
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week]["end"] = $weekData['end'];
                    $loanAccounts = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                        ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                        ->join("branch", "branch.branch_code", "loan_accounts.branch_code")
                        ->where(["loan_accounts.center_id" => $centerVal->center_id, "product.product_name" => 'micro group', "branch.branch_id" => $filters["branch_id"]])
                        ->whereDate('payment.transaction_date', '>=', $weekData['start'])
                        ->whereDate('payment.transaction_date', '<=', $weekData['end'])
                        ->groupBy("loan_accounts.loan_account_id")
                        ->select([DB::raw("count(payment.payment_id) as num_of_payments"), DB::raw("sum(payment.amount_applied-payment.rebates) as total_paid")])
                        ->get();
                    foreach ($loanAccounts as $key => $value) {
                        $data[$weekDay][$centerVal->center]["weeklyData"][$week]["num_of_payments"] += 1;
                        $data[$weekDay][$centerVal->center]["weeklyData"][$week]["total_paid"] += $value->total_paid;
                    }
                }
            }
        }
        return $data;
    }



    public function performanceReport($date)
    {
        $payments = new Payment();
        $accounts = new LoanAccount();
        $collection = $payments->getCollectionPaymentByBranch($date);
        $branchPortfolio = $accounts->getBranchPortfolio($date);
        $accountReleases = $accounts->getLoanAccountReleases($date);
        $data = [
            "portfolio" => $branchPortfolio,
            "collection" => $collection,
            "releases" => $accountReleases
        ];

        return $data;
    }

    public function microIndividual($filters = [], $weeksAndDays, $monthStart, $monthEnd)
    {
        $centers = Center::where(["status" => "active"])->get();
        $data = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
            ->join("center", "loan_accounts.center_id", "=", "center.center_id")
            ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
            ->join("branch", "branch.branch_code", "loan_accounts.branch_code")
            ->where(["product.product_name" => 'micro individual', "branch.branch_id" => $filters["branch_id"]])
            ->whereDate('payment.transaction_date', '>=', $monthStart)
            ->whereDate('payment.transaction_date', '<=', $monthEnd)
            ->groupBy("loan_accounts.borrower_id", "loan_accounts.center_id", "center.center", "center.day_sched", "loan_accounts.day_schedule")
            ->select([DB::raw("count(payment.payment_id) as num_of_payments"), DB::raw("sum(payment.amount_applied-payment.rebates) as total_paid"), "loan_accounts.borrower_id", "loan_accounts.center_id", "center.center", "loan_accounts.day_schedule as loanSched", "center.day_sched as centerSched"])
            ->get()->toArray();
        foreach ($data as $key => $paymentData) {
            $data[$key]["borrower"] = Borrower::find($paymentData['borrower_id'])->fullname();
            foreach ($weeksAndDays as $week => $weekData) {
                $loanAccounts = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                    ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->join("branch", "branch.branch_code", "loan_accounts.branch_code")
                    ->where([
                        "loan_accounts.center_id" => $paymentData['center_id'],
                        "loan_accounts.borrower_id" => $paymentData['borrower_id'],
                        "product.product_name" => "micro individual",
                        "branch.branch_id" => $filters["branch_id"]
                    ])
                    ->whereDate('payment.transaction_date', '>=', $weekData['start'])
                    ->whereDate('payment.transaction_date', '<=', $weekData['end'])
                    ->groupBy("loan_accounts.borrower_id", "loan_accounts.center_id")
                    ->select([DB::raw("count(payment.payment_id) as num_of_payments"), DB::raw("sum(payment.amount_applied-payment.rebates) as total_paid")])
                    ->first();
                $data[$key]["weeklyData"][$week] = $loanAccounts ? $loanAccounts : ["num_of_payments" => 0, "total_paid" => 0];
                $data[$key]["weeklyData"][$week]["start"] = $weekData['start'];
                $data[$key]["weeklyData"][$week]["end"] = $weekData['end'];
            }
        }
        return $data;
    }

    public function birTaxReport($filters = [])
    {
        // Fetch the raw data first
        $rawData = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
            ->join("borrower_info", 'loan_accounts.borrower_id', '=', 'borrower_info.borrower_id')
            ->where(["payment.status" => "paid"])
            ->whereDate('payment.transaction_date', '>=', $filters['date_from'])
            ->whereDate('payment.transaction_date', '<=', $filters['date_to'])
            ->groupBy("borrower_info.firstname", "borrower_info.middlename", "borrower_info.lastname")
            ->select([
                DB::raw("borrower_info.lastname as LAST_NAME_RAW"),
                DB::raw("borrower_info.firstname as FIRST_NAME_RAW"),
                DB::raw("UPPER(SUBSTRING(borrower_info.middlename, 1, 1)) as MIDDLE_NAM"),
                DB::raw("'' as ADDRESS"),
                DB::raw("'' as ADDRESS2"),
                // DB::raw("SUM(payment.interest + payment.pdi - payment.vat) as GSALES"),
                DB::raw("SUM(CASE WHEN payment.pdi_approval_no IS NOT NULL THEN payment.interest - payment.vat ELSE payment.interest + payment.pdi - payment.vat END) as GSALES"),
                DB::raw("SUM(CASE WHEN payment.pdi_approval_no IS NOT NULL THEN payment.interest - payment.vat ELSE payment.interest + payment.pdi - payment.vat END) as GTSALES"),
                // DB::raw("SUM(payment.interest + payment.pdi - payment.vat) as GTSALES"),
                DB::raw("'' as GESALES"),
                DB::raw("SUM(payment.vat) as TOUTTAX"),
                DB::raw("'12.00' as TAX_RATE"),
            ])
            ->having('GSALES', '>', 0)
            ->having('GTSALES', '>', 0)
            ->having('TOUTTAX', '>', 0)
            ->orderBy('borrower_info.lastname')
            ->get()
            ->toArray();

        // Function to capitalize each part of the name
        function capitalizeNameParts($name)
        {
            $parts = explode(' ', $name);
            $capitalizedParts = array_map(function ($part) {
                return ucfirst(strtolower($part));
            }, $parts);
            return implode(' ', $capitalizedParts);
        }

        // Process the fetched data
        $processedData = array_map(function ($row) {
            // Capitalize each part of the names
            $row['LAST_NAME'] = capitalizeNameParts(str_replace(['ñ', 'Ñ', '-'], ['n', 'N', ' '], $row['LAST_NAME_RAW']));
            $row['FIRST_NAME'] = capitalizeNameParts(str_replace(['ñ', 'Ñ', '-'], ['n', 'N', ' '], $row['FIRST_NAME_RAW']));

            // Handle middle name initials like "ma."
            if (!empty($row['MIDDLE_NAME'])) {
                $row['MIDDLE_NAME'] = strtoupper($row['MIDDLE_NAME']) . '.'; // Ensure middle name is in uppercase with a period
            }

            unset($row['LAST_NAME_RAW'], $row['FIRST_NAME_RAW']);
            return $row;
        }, $rawData);


        // foreach ($rawData as &$row){
        //     $row['GSALES'] = (int) $row['GSALES'];
        //     $row['GTSALES'] = (int) $row['GTSALES'];
        //     $row['TOUTTAX'] = (int) $row['TOUTTAX'];
        // }
        return $processedData;
    }

    public function prepaidReport($filters = [])
{
    $loanAccounts = $this->getLoanAccounts($filters);
    $data = [];
    
    foreach ($loanAccounts as $key => $value) {
        $releaseDate = new Carbon($value->date_release);
        $dueDate = new Carbon($value->due_date);

        // Calculate months difference
        $startMonth = $releaseDate->copy()->addMonthNoOverflow(1)->firstOfMonth();
        $endMonth = $dueDate->copy()->firstOfMonth();

        $monthsCount = 0;
        $tempDate = $startMonth->copy();
        while ($tempDate->lte($endMonth)) {
            $monthsCount++;
            $tempDate->addMonth();
        }

        // Ensure at least 1 month if there's prepaid interest
        if ($monthsCount == 0 && $value->prepaid_interest > 0) {
            $monthsCount = 1;
        }

        $monthly = $monthsCount > 0 ? ($value->prepaid_interest / $monthsCount) : 0;
        $balance = $value->prepaid_interest;
        
        // Start from date_release + 1 month
        $loanMonth = new Carbon($value->date_release);
        $loanMonth = $loanMonth->addMonthNoOverflow(1)->firstOfMonth()->startOfDay();
        
        // Due date is the end boundary
        $dueDate = new Carbon($value->due_date);
        $dueDate = $dueDate->firstOfMonth()->startOfDay();
        
        // Report range boundaries
        $reportFrom = new Carbon($filters["due_from"]);
        $reportFrom = $reportFrom->firstOfMonth()->startOfDay();
        
        $reportTo = isset($filters["due_to"]) 
            ? (new Carbon($filters["due_to"]))->endOfMonth()->startOfDay()
            : (new Carbon($filters["due_from"]))->endOfYear()->startOfDay();
        
        $history = [];
        
        // ✅ FIX: Check if loan is PAID
        $isPaid = $value->loan_status === LoanAccount::LOAN_PAID;
        
        // Loop through each month from loan start to due date
        while ($loanMonth->lte($dueDate)) {
            $year = $loanMonth->format('Y');
            $month = $loanMonth->format('m');
            
            // Initialize year array if not exists
            if (!isset($history[$year])) {
                $history[$year] = [
                    "01" => 0, "02" => 0, "03" => 0, "04" => 0,
                    "05" => 0, "06" => 0, "07" => 0, "08" => 0,
                    "09" => 0, "10" => 0, "11" => 0, "12" => 0,
                ];
            }

            // Calculate the monthly amount (considering remaining balance)
            $monthlyAmount = min($monthly, $balance);

            $history[$year][$month] = round($monthlyAmount, 2);
            $balance -= $monthlyAmount;

            // Ensure balance doesn't go negative
            if ($balance < 0.01) { // Using 0.01 to handle rounding errors
                $balance = 0;
            }
            
            $loanMonth = $loanMonth->addMonth(1)->startOfDay();
        }
        
        // ✅ FIXED: Set balance based on loan status
        $activeStatuses = [
            LoanAccount::LOAN_ONGOING, 
            LoanAccount::LOAN_PASTDUE, 
            LoanAccount::LOAN_RESTRUCTED, 
            LoanAccount::LOAN_RES_WO_PDI, 
            LoanAccount::LOAN_WRITEOFF
        ];
        
        // For active loans, balance should be the full prepaid interest
        // For paid loans, balance should be 0
        if (in_array($value->loan_status, $activeStatuses)) {
            $balance = $value->prepaid_interest;
        } else if ($isPaid) {
            $balance = 0;
        }
        
        $data[] = [
            "branch_id" => $value->branch->branch_id,
            "client" => $value->borrower->fullname(),
            "amount_loan" => $value->loan_amount,
            "date_released" => $value->date_release,
            "due_date" => $value->due_date,
            "term" =>  $value->terms . ' \ ' . ceil($value->terms / 30),
            "interest_rate" => $value->interest_rate,
            "total_uid" => $value->prepaid_interest,
            "balance" => $balance,
            "monthly_uid" => $monthly,
            "history" => $history,
            "loan_status" => $value->loan_status,

        ];
    }
    
    return $data;
}
}
