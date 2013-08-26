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

/**
 * 
 */
class NameDayResult
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $holyDay;

    /**
     * @param string $name
     * @param bool $holyDay
     */
    public function __construct($name, $holyDay)
    {
        $this->name    = $name;
        $this->holyDay = (bool) $holyDay;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isHolyDay()
    {
        return $this->holyDay;
    }
}
