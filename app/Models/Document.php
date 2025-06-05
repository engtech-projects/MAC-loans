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


        $num = Document::select('promissory_number')
            ->where('promissory_number', 'LIKE', '%-' . $productCode . '-%')
            ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(promissory_number, '-', -1), '-', 1) DESC")
            ->limit(1)
            ->get();
        //$num = Document::where('promissory_number', 'LIKE', '%-' . $productCode . '-%')->orderBy('promissory_number', 'DESC')->pluck('promissory_number');


        $promissoryNumber = $num->pluck('promissory_number');

        if(count($promissoryNumber) >0) {
            $series = explode('-',$promissoryNumber);
            $identifier = (int)$series[2] +1;
        }else {
            $identifier = 1;
        }
        $promisorryNum = $branchCode . '-' . $productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);
        $this->saveDocument($promisorryNum);

        return $promisorryNum;

    }

    public function saveDocument($promisorryNum) {
        Document::create([
            'promissory_number' => $promisorryNum,
        ]);
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
