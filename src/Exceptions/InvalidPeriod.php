<?php

namespace Spatie\Analytics\Exceptions;

use Exception;

class InvalidPeriod extends Exception
{
    public static function startDateCannotBeAfterEndDate($startDate, $endDate)
    {
        return new static("Start date `{$startDate->format('Y-m-d')}` cannot be after end date `{$endDate->format('Y-m-d')}`.");
    }
}
