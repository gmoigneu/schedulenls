<?php

namespace App\Helpers;

class DateIntervalHelper {

    static function dateIntervalToMinutes(\DateInterval $dateInterval)
	{
	    $reference = new \DateTimeImmutable;
	    $endTime = $reference->add($dateInterval);

	    return floor(($endTime->getTimestamp() - $reference->getTimestamp())/60);
	}
}