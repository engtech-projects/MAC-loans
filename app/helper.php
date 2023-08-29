<?php

use Carbon\Carbon;

function getMonths()
{
    $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    return $months;
}
function getMonth($date)
{
    $year = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
    return $year;
}
function getYear($date)
{
    $month = Carbon::createFromFormat('Y-m-d', $date)->format('m');
    return $month;
}
function isActive($nav1, $nav2)
{
    return $nav1 == $nav2;
}

function isActiveNav($nav1, $nav2)
{
    if ($nav1 == $nav2) {
        return 'active';
    }
    return '';
}

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
