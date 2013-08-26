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
interface NamesInterface extends \ArrayAccess
{
    /**
     * @return array
     */
    public function getHolyDays();
}
