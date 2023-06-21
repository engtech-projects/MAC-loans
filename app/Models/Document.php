<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'id';

    protected $fillable = [
        'loan_account_id', 'date_release', 'description', 'bank', 'account_no', 'card_no', 'promissory_number'

    ];


    public function getPromissoryNo($branchCode, $productCode, $identifier = 1)
    {

        //$num = LoanAccount::where('account_num', 'LIKE','%-' . $productCode . '-%')->orderBy('account_num','DESC')->limit(1)->pluck('account_num');

        /* $num = Document::where('promissory_number', 'LIKE', '%-' .$productCode. '-%')->pluck('promissory_number'); */


/*         $num = Document::where('promissory_number', 'LIKE', '%-' . $productCode . '-%')
            ->orderByDesc(function ($query) use ($productCode) {
                $query->select('promissory_number')
                    ->from('documents')
                    ->whereRaw('promissory_number LIKE "%-' . $productCode . '-%"')
                    ->orderBy('promissory_number', 'DESC')
                    ->limit(1);
            })->pluck('promissory_number');
 */
/*         $aa = Document::where('promissory_number', 'LIKE', '%-' . $productCode . '-%')
            ->orderByRaw("SUBSTRING_INDEX(promissory_number, '-', -1) + 0 DESC")
            ->pluck('promissory_number');
 */

        $num = Document::select('promissory_number')
            ->where('promissory_number', 'LIKE', '%-' . $productCode . '-%')
            ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(promissory_number, '-', -1), '-', 1) DESC")
            ->get();
        //$num = Document::where('promissory_number', 'LIKE', '%-' . $productCode . '-%')->orderBy('promissory_number', 'DESC')->pluck('promissory_number');
        $num = Document::where('promissory_number', 'LIKE', '%-' .$productCode. '-%')->pluck('promissory_number')->last();


        $promissoryNumber = $num->pluck('promissory_number');
        if(count($promissoryNumber) >0) {
            $series = explode('-',$promissoryNumber);
            $identifier = (int)$series[2] +1;
        }else {
            $identifier = 1;
        }


/*         $promissoryNumSeries = [];
        foreach ($num as $numVal) {
            $numSeries = explode('-', $numVal);
            if (isset($numSeries[1]) && strpos($numSeries[1], $productCode) !== false) {
                $promissoryNumSeries[] = $numVal;
            }
        }

        usort($promissoryNumSeries, function ($a, $b) {
            $seriesDashA = explode('-', $a)[2];
            $seriesDashB = explode('-', $b)[2];
            return $seriesDashB - $seriesDashB;
        });

        $series = [];
        foreach ($promissoryNumSeries as $seriesKey => $seriesVal) {
            $number = explode('-', $seriesVal);
            $series[$seriesKey] = $number[2];
        }
        array_multisort($series, SORT_DESC, $promissoryNumSeries);
        if (count($promissoryNumSeries) > 0) {
            $seriesNumber = $promissoryNumSeries[0];
            $lastDigit = explode('-', $seriesNumber);
            $identifier = (int)$lastDigit[2] + 1;
        } else {
            $identifier = 1;
        } */


        return $branchCode . '-' . $productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);

        // $id = Document::max('id');
        // $series = str_pad($id, 7, '0', STR_PAD_LEFT);
        // return $branchCode . '-' . $productCode . '-' . $series;

    }

    public function deleteDocument($loan_account_id)
    {
        //get document if exists in document table
        $document = Document::where('loan_account_id', $loan_account_id)->first();

        //check document
        if ($document) {
            //delete document
            $document->delete();
        }
        return false;
    }
}
