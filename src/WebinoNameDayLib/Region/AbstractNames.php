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
    /**
     * List of name days
     *
     * @var string
     */
    protected $names = array();

    /**
     * List of holy days numbers
     *
     * @var array
     */
    protected $holyDays = array();

    /**
     * Regular expression pattern to split name day for multiple names
     *
     * @var string
     */
    protected $splitPattern = '~(, )~';

    /**
     */
    public function __construct()
    {
        parent::__construct($this->names);
    }

    /**
     * @return array
     */
    public function getHolyDays()
    {
        return $this->holyDays;
    }

    /**
     * Regular expression pattern to split name day for multiple names
     *
     * @return string
     */
    public function getSplitPattern()
    {
        return $this->splitPattern;
    }

    /**
     * @param string $needle
     * @return int|null
     */
    public function search($needle)
    {
        $normalizedNeedle = $this->normalizeName($needle);

        foreach ($this as $day => $name) {

            if ($name === $normalizedNeedle) {
                return $day;
            }

            foreach (preg_split($this->splitPattern, $name) as $subName) {
                if ($subName === $normalizedNeedle) {
                    return $day;
                }
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeName($name)
    {
        return ucfirst($name);
    }
}
