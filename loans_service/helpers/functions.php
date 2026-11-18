<?php
function checkStatus($loan, $return, $numberDays): string{
    $loan_dateTime = new DateTime($loan);
    $loan_dateTime->modify('+'.$numberDays.' days');
    $now = new DateTime('now');
    if($return === 'null' && $loan_dateTime >= $now) return 'Active';
    else if ($return !== 'null' /*&& $loan_dateTime >= $now*/) return 'Returned';
    else return 'Overdue';
}

function calculateFee($loan, $return, $numberDays): int {
    $due = (new DateTimeImmutable($loan))->modify('+' . (int) $numberDays . ' days');

    $end = $return !== 'null'
        ? new DateTimeImmutable($return)
        : new DateTimeImmutable('today');

    if ($end <= $due) {
        return 0;
    }

    $lateDays = (int) $due->diff($end)->days;
    return $lateDays * 10;
}