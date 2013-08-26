<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoNameDayLib for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoNameDayLib;

use DateTime;

/**
 * 
 */
class NameDay
{
    /**
     * @var National\NamesInterface
     */
    protected $names;

    /**
     * @var array
     */
    protected $dayCache = array();

    /**
     * @param National\NamesInterface $names
     */
    public function __construct(National\NamesInterface $names)
    {
        $this->names = $names;
    }

    /**
     * @param string $date
     * @return NameDayResult
     */
    public function today($date = 'now')
    {
        $day = $this->resolveDay($date);
        return $this->createNameDayResult($day);
    }

    /**
     * @param string $date
     * @return NameDayResult
     */
    public function tomorrow($date = 'now')
    {
        $day     = $this->resolveDay($date);
        $nextDay = $this->resolveNextDay($day);
        return $this->createNameDayResult($nextDay);
    }

    /**
     * Today & tomorrow
     *
     * @param string $date
     * @return array Collection of NameDayResults
     */
    public function combo($date = 'now')
    {
        return array($this->today($date), $this->tomorrow($date));
    }

    /**
     * @param string $day
     * @return NameDayResult
     */
    protected function createNameDayResult($day)
    {
        return new NameDayResult($this->names[$day], $this->resolveHolyDay($day));
    }

    /**
     * Return the day number
     *
     * @param string $date
     * @return int
     */
    protected function resolveDay($date)
    {
        if (isset($this->dayCache[$date])) {
            return $this->dayCache[$date];
        }

        $dateTime = new DateTime($date);
        $day      = $dateTime->format('z');

        if (!$dateTime->format('L') && $day >= 59) {
            // fix no leap year
            $day++;
        }

        return $this->dayCache[$date] = $day;
    }

    /**
     * Return the next day number
     *
     * @param int $day
     * @return int
     */
    protected function resolveNextDay($day)
    {
        $nextDay = $day + 1;
        if (!empty($this->names[$nextDay])) {
            return $nextDay;
        }
        return 0;
    }

    /**
     * Return true if it's holyday
     *
     * @param int $day
     * @return bool
     */
    protected function resolveHolyDay($day)
    {
        $holyDays = array_flip($this->names->getHolyDays());
        return isset($holyDays[$day]);
    }
}
