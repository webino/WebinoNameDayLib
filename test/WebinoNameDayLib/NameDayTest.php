<?php

namespace WebinoNameDayLib;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-08-26 at 10:13:24.
 */
class NameDayTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NameDay
     */
    protected $object;

    /**
     * @var WebinoNameDayLib\Region\AbstractNames
     */
    protected $names;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->names  = $this->getMock('WebinoNameDayLib\Region\AbstractNames');
        $this->object = new NameDay($this->names);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     *
     */
    public function testToday()
    {
        $date     = '4.1.2013';
        $name     = 'Some name';
        $holyDays = array();

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->today($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);
        $this->assertSame($name, $result->getName());
        $this->assertFalse($result->isHolyDay());
    }

    /**
     *
     */
    public function testTodayLeapYear()
    {
        $date     = '1.3.2015';
        $name     = 'Some name';
        $holyDays = array();

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->today($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);
        $this->assertSame($name, $result->getName());
        $this->assertFalse($result->isHolyDay());
    }

    /**
     *
     */
    public function testTodayHolyDay()
    {
        $date     = '4.1.2013';
        $name     = 'Some name';
        $holyDays = array(3);

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->today($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);

        $this->assertSame($name, $result->getName());
        $this->assertTrue($result->isHolyDay());
    }

    /**
     *
     */
    public function testTomorrow()
    {
        $date     = '4.1.2013';
        $name     = 'Some name';
        $holyDays = array(3);

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->tomorrow($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);

        $this->assertSame($name, $result->getName());
        $this->assertFalse($result->isHolyDay());
    }

    /**
     *
     */
    public function testTomorrowHolyDay()
    {
        $date     = '4.1.2013';
        $name     = 'Some name';
        $holyDays = array(4);

        $this->names->expects($this->once())
            ->method('offsetExists')
            ->will($this->returnValue(true));

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->tomorrow($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);

        $this->assertSame($name, $result->getName());
        $this->assertTrue($result->isHolyDay());
    }

    /**
     *
     */
    public function testTomorrowHolyDayNewYear()
    {
        $date     = '4.1.2013';
        $name     = 'Some name';
        $holyDays = array(0);

        $this->names->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($name));

        $this->names->expects($this->once())
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->tomorrow($date);

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $result);

        $this->assertSame($name, $result->getName());
        $this->assertTrue($result->isHolyDay());
    }

    /**
     *
     */
    public function testCombo()
    {
        $date     = '4.1.2013';
        $names    = array(3 => 'Some name', 4 => 'Some name 2');
        $holyDays = array(4);

        $this->names->expects($this->once())
            ->method('offsetExists')
            ->will($this->returnValue(true));

        $this->names->expects($this->exactly(2))
            ->method('offsetGet')
            ->will(
                $this->returnCallback(
                    function ($index) use ($names) {
                        return $names[$index];
                    }
                )
            );

        $this->names->expects($this->exactly(2))
            ->method('getHolyDays')
            ->will($this->returnValue($holyDays));

        $result = $this->object->combo($date);

        $this->assertTrue(is_array($result));

        list($today, $tomorrow) = $result;

        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $today);
        $this->assertInstanceOf('WebinoNameDayLib\NameDayResult', $tomorrow);

        $this->assertSame($names[3], $today->getName());
        $this->assertFalse($today->isHolyDay());

        $this->assertSame($names[4], $tomorrow->getName());
        $this->assertTrue($tomorrow->isHolyDay());
    }
}
