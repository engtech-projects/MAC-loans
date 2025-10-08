<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
{
    use HasFactory;

    protected $table = 'accessibility';
    protected $primaryKey = 'access_id';

    protected $fillable = [
        'label',
        'group',
        'permission',
        'description'
    ];

    public function permissions()
    {

        $groups = [
            'Client Information',
            'Transaction',
            'Maintenance',
            'Reports',
            'End of Day',
            'Data'
        ];

        $accessibility = [];

        foreach ($groups as $group) {

            $accessibility[$group] = Accessibility::where(['group' => $group])->get();

            if (count($accessibility[$group]) > 0) {

                foreach ($accessibility[$group] as $key => $value) {
                    $value->child_permissions = Accessibility::where(['group' => $value->label])->get();
                }
            }
        }
        return $accessibility;
    }

    public function user_accessibility()
    {
        return $this->belongsToMany(
            User::class,
            'user_accessibility',
            'id',
            'access_id'
        )->withTimestamps();
    }
}
