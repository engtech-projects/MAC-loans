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

        $num = Document::where('promissory_number', 'LIKE', '%'.$branchCode . '-' .$productCode.'%')->get()->pluck('promissory_number')->last();

        if( $num ) {
         $series = explode('-', $num);
         $identifier = (int)$series[2] + 1;
        }

        return $branchCode . '-' .$productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);

    	// $id = Document::max('id');
    	// $series = str_pad($id, 7, '0', STR_PAD_LEFT);
    	// return $branchCode . '-' . $productCode . '-' . $series;

    }

    public function deleteDocument($loan_account_id) {
        $document = Document::where('loan_account_id',$loan_account_id)->get();
        if($document) {
            $document->destroy();
        }
    }
}
