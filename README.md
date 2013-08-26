# Webino Name Day Library

[![Build Status](https://secure.travis-ci.org/webino/WebinoNameDayLib.png?branch=master)](http://travis-ci.org/webino/WebinoNameDayLib "Master")
[![Build Status](https://secure.travis-ci.org/webino/WebinoNameDayLib.png?branch=develop)](http://travis-ci.org/webino/WebinoNameDayLib "Develop")

Provides API to resolve name day. **Still under development.** (currently only Slovak)

## Features

  - Today and tomorrow name day according to the date
  - Holy day flag

## Setup

  Following steps are necessary to get this library working:

  1. Add `"minimum-stability": "dev"` to your composer.json, because this lib is under development

  2. Run `php composer.phar require webino/webino-name-day-lib:dev-develop`

## Requirements

  - PHP 5.3

## QuickStart

        // Create the name day service
        $locale  = 'sk_SK';
        $factory = new \WebinoNameDayLib\Factory;
        $nameDay = $factory->create($locale);

        // Get the name day
        $result = $nameDay->today();

        // Holy day logic (optional)
        if ($result->isHolyDay()) {
            $text = 'Today is';
        } else {
            $text = 'Name-day today celebrating';
        }

        // Name day of the day
        $result->getName();

        // Get tomorrow name day
        $result = $nameDay->tomorrow();

        // Get today & tomorrow name day
        $arrayOfResults = $nameDay->combo();

## Functions

### The service

  * `NameDayResult today($date = 'now')`
  * `NameDayResult tomorrow($date = 'now')`
  * `array[NameDayResult, NameDayResult] combo($date = 'now')`


### The result

  * `string getName()`
  * `bool isHolyDay()`

## Develop

**Requirements**

  - Linux (recommended)
  - NetBeans (optional)
  - Phing
  - PHPUnit

**Setup**

  1. Clone this repository and run: `phing update`

     Now your development environment is set.

  2. Open project in the (NetBeans) IDE

**Adding region names**

  1. Look at the `\WebinoNameDayLib\Region\Sk`
  2. It's best to extend `\WebinoNameDayLib\Region\AbstractNames`

**Testing**

  - Run `phpunit` in the test directory
  - Run `phing test` in the module directory to run the tests and code insights

    *NOTE: To run the code insights there are some tool requirements.*

## Todo

  - Add Czech names
  - Add other nation names

## Addendum

Please, if you are interested in this library report any issues and don't hesitate to contribute.
