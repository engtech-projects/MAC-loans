<?php

use App\Models\EndTransaction;

function transactionDate($branchId) {
    $tranDate = new EndTransaction();
    $transactionDateNow = $tranDate->getTransactionDate($branchId)->date_end;
    return $transactionDateNow;
}
function isActive($nav1, $nav2){
	return $nav1 == $nav2;
}

function isActiveNav($nav1, $nav2){
	if($nav1 == $nav2){
		return 'active';
	}
	return '';
}

function objToArray($data) {
    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }

    return $data;
}
