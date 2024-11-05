<?php

declare(strict_types=1);

namespace Common\Utils;

/**
 * @author None
 */
class DateUtils
{
    public static function getStartOfWeekDate($date = null)
    {
        if ($date instanceof \DateTime) {
            $date = clone $date;
        } elseif (!$date) {
            $date = new \DateTime();
        } else {
            $date = new \DateTime($date);
        }

        $date->setTime(0, 0, 0);

        if ($date->format('N') === '1') {
            // If the date is already a Monday, return it as-is
            return $date;
        }

        // Otherwise, return the date of the nearest Monday in the past
        // This includes Sunday in the previous week instead of it being the start of a new week
        return $date->modify('last monday');
    }

    public static function getDaysSinceDate(\DateTime $datetime): int
    {
        $now = new \DateTime();

        return (int) $datetime->diff($now)->format('%a');
    }
}
