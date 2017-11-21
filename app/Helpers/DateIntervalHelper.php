<?php

namespace App\Helpers;

class DateIntervalHelper {

static function dateIntervalToMinutes($dateInterval)
	{
	    $reference = new \DateTimeImmutable;
	    $endTime = $reference->add(\Carbon\CarbonInterval::minutes($dateInterval));

	    return floor(($endTime->getTimestamp() - $reference->getTimestamp())/60);
	}
}