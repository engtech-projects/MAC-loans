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


    public function getPromissoryNo($branchCode, $productCode, $identifier = 1) {

        //$num = LoanAccount::where('account_num', 'LIKE','%-' . $productCode . '-%')->orderBy('account_num','DESC')->limit(1)->pluck('account_num');

        //$num = Document::where('promissory_number', 'LIKE', '%-' . $productCode . '-%')->orderBy('promissory_number', 'DESC')->pluck('promissory_number');
        $num = Document::where('promissory_number', 'LIKE', '%-' .$productCode. '-%')->pluck('promissory_number')->last();

        if($num) {
         $series = explode('-', $num);
         dd($series);
         $identifier = (int)$series[2] + 1;
        }else {
            $identifier = 1;
        }
        return $branchCode . '-' .$productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);

    	// $id = Document::max('id');
    	// $series = str_pad($id, 7, '0', STR_PAD_LEFT);
    	// return $branchCode . '-' . $productCode . '-' . $series;

    }

    public function deleteDocument($loan_account_id) {
        //get document if exists in document table
        $document = Document::where('loan_account_id',$loan_account_id)->first();

        //check document
        if($document) {
            //delete document
            $document->delete();
        }
        return false;
    }
}
