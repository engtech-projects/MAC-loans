<?php

use App\Models\EndTransaction;


if (!function_exists('transactionDate')) {
    function transactionDate($branchId)
    {
        $tranDate = new EndTransaction();
        $transactionDateNow = $tranDate->getTransactionDate($branchId)->date_end;
        return $transactionDateNow;
    }
}
/* function transactionDate($branchId)
{
    $tranDate = new EndTransaction();
    $transactionDateNow = $tranDate->getTransactionDate($branchId)->date_end;
    return $transactionDateNow;
} */
if (!function_exists('isActive')) {
    function isActive($nav1, $nav2)
    {
        return $nav1 == $nav2;
    }
}



if (!function_exists('isActiveNav')) {
    function isActiveNav($nav1, $nav2)
    {
        if ($nav1 == $nav2) {
            return 'active';
        }
        return '';
    }
}
if (!function_exists('objToArray')) {
    function objToArray($data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(__FUNCTION__, $data);
        }

        return $data;
    }
}
