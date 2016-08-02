<?php

namespace Spatie\Analytics;

use Carbon\Carbon;
use Spatie\Analytics\Exceptions\InvalidPeriod;

class Period
{
    /** @var \DateTime */
    public $startDate;

    /** @var \DateTime */
    public $endDate;

    public static function create($startDate, $endDate)
    {
        return new static($startDate, $endDate);
    }

    public static function days(int $numberOfDays)
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subDays($numberOfDays)->startOfDay();

        return new static($startDate, $endDate);
    }

    public function __construct($startDate, $endDate)
    {
        if ($startDate > $endDate) {
            throw InvalidPeriod::startDateCannotBeAfterEndDate($startDate, $endDate);
        }

        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }
}
