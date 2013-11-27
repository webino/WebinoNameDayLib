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
     * @var Region\NamesInterface
     */
    protected $names;

    /**
     * @var array
     */
    protected $dayCache = array();

    /**
     * @param Region\NamesInterface $names
     */
    public function __construct(Region\NamesInterface $names)
    {
        $this->names = $names;
    }

    /**
     * Regular expression pattern to split name day for multiple names
     *
     * @return string
     */
    public function getNameSplitPattern()
    {
        return $this->names->getSplitPattern();
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
     * Date of name day for a name
     *
     * @todo Can't use just DateTime from z format because of a leap year bug: https://bugs.php.net/bug.php?id=62476
     * @param string $name
     * @return DateTime|null
     */
    public function nameDate($name)
    {
        $day = $this->names->search($name);
        if (null === $day) {
            return null;
        }

        $dateTimeNow = $this->createDateTime();

        if (!$dateTimeNow->format('L') && $day >= 59) {
            // fix no leap year
            $day--;
        }

        // DateTime bug hack
        $time = strtotime($day . ' day', strtotime('1.1.' . $dateTimeNow->format('Y')));
        $date = date('d.m.Y', $time);

        return DateTime::createFromFormat('d.m.Y', $date);
    }

    /**
     * Nearest valid name day date for a name
     *
     * When name day already was for the current year returns date for the next year.
     *
     * @param string $name
     * @return DateTime|null
     */
    public function nearestNameDate($name)
    {
        $nameDateTime = $this->nameDate($name);
        if (null === $nameDateTime) {
            return null;
        }

        $dateTimeNow = $this->createDateTime();

        if ($nameDateTime->format('Ynj') < $dateTimeNow->format('Ynj')) {

            return $this->createDateTime(
                $nameDateTime->format('d.m.')
                . ($nameDateTime->format('Y') + 1)
            );
        }

        return $nameDateTime;
    }

    /**
     * @param string $time
     * @return DateTime
     */
    protected function createDateTime($time = 'now')
    {
        return new DateTime($time);
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
     * The day number
     *
     * @param string $date
     * @return int
     */
    protected function resolveDay($date)
    {
        if (isset($this->dayCache[$date])) {
            return $this->dayCache[$date];
        }

        $dateTime = $this->createDateTime($date);
        $day      = $dateTime->format('z');

        if (!$dateTime->format('L') && $day >= 59) {
            // fix no leap year
            $day++;
        }

        return $this->dayCache[$date] = $day;
    }

    /**
     * The next day number
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
     * True if it's holyday
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
