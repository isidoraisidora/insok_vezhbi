<?php
function calculateEnd($start, $type): DateTime{
    $startDate = new DateTime($start);
    if($type === 'Monthly') $startDate->modify('+1 month');
    else $startDate->modify('+1 year');
    return $startDate;
}

function checkStatus($start, $type): string{
    $end = calculateEnd($start, $type);
    $today = new DateTime('now');
    if ($end >= $today) return 'Active';
    else return 'Expired';
}