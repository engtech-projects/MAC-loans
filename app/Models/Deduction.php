<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class Deduction extends Model
{
    use HasFactory;
    protected $table = 'deduction_rate';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'rate',
        'product_id',
        'term_start',
        'term_end',
        'age_start',
        'age_end',
        'deleted',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $deductions = [
        'filing_fee' => ['label' => 'filing', 'rate' => 0],
        'doc_stamp' => ['label' => 'documentary', 'rate' => 0],
        'insurance' => ['label' => 'insurance', 'rate' => 0],
        'notarial_fee' => ['label' => 'notarial', 'rate' => 0],
        'prepaid_interest' => ['label' => 'prepaid', 'rate' => 0],
        'affidavit' => ['label' => 'affidavit', 'rate' => 0],
        // 'memo' => [ 'label' => 'memo', 'rate' => 0 ]
    ];
    public function deductions($constraints = [])
    {

        foreach ($this->deductions as $key => $value) {

            switch ($key) {
                case 'filing_fee':
                    $this->deductions[$key]['rate'] = $this->filing($constraints, $value['label']);
                    break;
                case 'insurance':
                    $this->deductions[$key]['rate'] = $this->insurance($constraints, $value['label']);
                    break;
                case 'doc_stamp':
                    $this->deductions[$key]['rate'] = $this->documentary($constraints, $value['label']);
                    break;
                case 'notarial_fee':
                    $this->deductions[$key]['rate'] = $this->notarial($value['label']);
                    break;
                case 'prepaid_interest':
                    $this->deductions[$key]['rate'] = $this->prepaid($value['label']);
                    break;
                case 'affidavit':
                    $this->deductions[$key]['rate'] = $this->affidavit($value['label']);
                    break;
                    // case 'memo':
                    // 	$this->deductions[$key]['rate'] = $this->memo($value['label']);
                    // 	break;

            }
        }

        return $this->deductions;
    }

    public function filing($constraints = [], $ref)
    {

        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')
            ->where(['product_id' => $constraints['product_id']])
            ->get();


        if (count($data) > 0) {
            foreach ($data as $d) {

                if ($d->term_start) {

                    if ($d->term_start <= $constraints['terms'] && $d->term_end >= $constraints['terms']) {
                        return $constraints['loan_amount'] * ((float)$d->rate / 100);
                    }
                } else {
                    return $d->rate;
                }
            }
        }

        return 0;
    }

    public function insurance($constraints = [], $ref)
    {
        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')
            ->where('age_start', '<=', $constraints['age'])
            ->where('age_end', '>=', $constraints['age'])
            ->where('term_start', '<=', $constraints['terms'])
            ->where('term_end', '>=', $constraints['terms'])
            ->first();

        if (!$data) {
            return 0;
        }

        $months = $constraints['terms'] / 30;
        $amount = ($constraints['loan_amount'] / 1000) * $data->rate * $months;

        return round($amount);
    }

    public function documentary($constraints = [], $ref)
    {

        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')
            ->where('term_start', '<=', $constraints['terms'])
            ->where('term_end', '>=', $constraints['terms'])
            ->first();


        if (!$data) {
            return 0;
        }

        $terms = (int)$constraints['terms'] / 30;
        $amount = 0;

        if ($terms <= 12) {
            $amount = $constraints['loan_amount'] / $data->rate * 1.50 * $constraints['terms'] / 365;
        } else {
            $amount = $constraints['loan_amount'] / $data->rate * 1.50;
        }

        return ceil($amount);
    }

    public function notarial($ref)
    {
        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')->first();

        if (!$data) {
            return 0;
        }

        return $data->rate;
    }

    public function prepaid($ref)
    {
        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')->first();

        if (!$data) {
            return 0;
        }

        return $data->rate;
    }

    public function affidavit($ref)
    {
        $data = Deduction::where('name', 'LIKE', '%' . $ref . '%')->first();

        if (!$data) {
            return 0;
        }

        return $data->rate;
    }

    //   public function memo($ref) {
    // $data =
    //   }

}
