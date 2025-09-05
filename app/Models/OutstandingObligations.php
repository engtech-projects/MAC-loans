<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutstandingObligations extends Model
{
    use HasFactory;
    protected $table = 'outstanding_obligations';
    protected $primaryKey = 'id';

    protected $fillable = [
	    'borrower_id',
		'creditor',
		'amount',
		'balance',
		'term',
		'due_date',
		'amortization',
    ];

	protected $casts = [
		'created_at' => "datetime:Y-m-d H:i:s",
		'updated_at' => "datetime:Y-m-d H:i:s"
	];
}
