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


    public function getPromissoryNo($branchCode, $productCode) {

    	$id = Document::max('id');
    	$series = str_pad($id, 7, '0', STR_PAD_LEFT);
    	return $branchCode . '-' . $productCode . '-' . $series;

    }
}
