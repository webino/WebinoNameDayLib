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

use Locale;
use InvalidArgumentException;
use RuntimeException;

/**
 *
 */
class Factory
{
    /**
     * Creates NameDay object from locale
     *
     * @param string $locale e.g. sk_SK
     * @return \WebinoNameDayLib\NameDay
     * @throws \RuntimeException
     */
    public function create($locale)
    {
        $parsedLocale = Locale::parseLocale($locale);

        if (empty($parsedLocale['region'])) {
            throw new InvalidArgumentException('Could not parse locale ' . $locale);
        }

        $class = __NAMESPACE__ . '\Region\\' . ucfirst(strtolower($parsedLocale['region']));

        if (!class_exists($class)) {
            throw new RuntimeException('Could not find a ' . $class);
        }

        return new NameDay(new $class);
    }
}
