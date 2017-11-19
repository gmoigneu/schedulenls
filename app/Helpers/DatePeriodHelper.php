<?php

namespace App\Helpers;

class DatePeriodHelper extends \DatePeriod {
    /**
     * What is the overlap, in minutes, of two time periods?
     * Based on a stackoverflow answer by Ed Cottrell - Thanks Ed :)
     * http://stackoverflow.com/questions/33270716/return-the-amount-of-overlapping-minutes-between-to-php-dateperiods
     * 
     * @param DatePeriod $period    The DatePeriod to compare $this to.
     * @return DateInterval        A DateInterval object expressing the overlap or (if negative) the distance between the DateRanges
     */
    public function overlapsWithPeriod(\DatePeriod $period) {
        // Figure out which is the later start time
        $lastStart = $this->getStartDate() >= $period->getStartDate() ? $this->getStartDate() : $period->getStartDate();

        // Figure out which is the earlier end time
        $firstEnd = $this->getEndDate() <= $period->getEndDate() ? $this->getEndDate() : $period->getEndDate();

        // Subtract the two, divide by 60 to convert seconds to minutes, and round down
        $overlap = floor(($firstEnd->getTimestamp() - $lastStart->getTimestamp()) / 60);

        // If the answer is greater than 0 use it.
        // If not, there is no overlap.
        return $overlap > 0 ? $overlap : 0;
    }
}