<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoNameDayLib for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoNameDayLib\Region;

/**
 *
 */
abstract class AbstractNames extends \ArrayObject implements
     NamesInterface
{
    protected $names = array();

    protected $holyDays = array();

    public function __construct()
    {
        parent::__construct($this->names);
    }

    public function getHolyDays()
    {
        return $this->holyDays;
    }
}
