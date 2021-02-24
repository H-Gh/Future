<?php

namespace Services;

use App\Services\MarsClock;
use Carbon\Carbon;
use TestCase;

/**
 * The test for mars class
 * PHP version >= 8.0
 *
 * @category Tests
 * @package  Future
 * @author   Hamed Ghasempour <hamedghasempour@gmail.com>
 */
class MarsClockTest extends TestCase
{
    /**
     * @return void
     */
    public function testMarsSolDate(): void
    {
        // Date and time (GMT): Friday, October 16, 2020 2:35:29 AM
        $timestamp = 1602815729;
        $carbon = Carbon::createFromTimestamp($timestamp);
        $marsClock = new MarsClock($carbon);
        self::assertEquals(52182.05587, $marsClock->getMsd());
    }

    /**
     * @return void
     */
    public function martianCoordinatedTime(): void
    {
        // Date and time (GMT): Friday, October 16, 2020 2:35:29 AM
        $timestamp = 1602815729;
        $carbon = Carbon::createFromTimestamp($timestamp);
        $marsClock = new MarsClock($carbon);
        self::assertEquals("01:20:27", $marsClock->getMtc());
    }
}
