<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    use HasFactory;

    protected $table = 'general_ledger';
    protected $primaryKey = 'gl_id';

    protected $fillable = [
        'loans',
        'code',
        'accounting',
        'type',
    ];
    const CASH_IN_BANK_BDO = 'Cash in Bank - BDO';
    const CASH_IN_BANK_METROBANK = 'Cash in Bank - BDO';
    const BDO = 'BDO';
    const METROBANK = 'METROBANK';
    const BDO_ACCT = "1060";
    const METROBANK_ACC = "1050";


    public function ledger($type)
    {

        $glAccounts = GeneralLedger::where(['type' => $type])->get();

        $ledger = [];
        foreach ($glAccounts as $gl) {

            $ledger[] = array(
                'id' => ChartOfAccounts::where(['account_number' => $gl->code])->first()->account_id,
                'acct' => $gl->code,
                'title' => $gl->accounting,
                'reference' => $gl->loans,
                'sl' => '',
                'debit' => 0,
                'credit' => 0
            );
        }

        return $ledger;
    }

    public function getDataFromLedger(array $ledger, $identifier, $recordType = 'debit')
    {


        foreach ($ledger as $key => $value) {


            if ($value['reference'] === $identifier) {

                return $value[$recordType];
            }
        }
    }
}
