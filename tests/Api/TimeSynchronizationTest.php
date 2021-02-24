<?php

namespace Api;

use TestCase;

/**
 * The test for TimeSynchronizationController endpoint
 * PHP version >= 8.0
 *
 * @category Tests
 * @package  Future
 * @author   Hamed Ghasempour <hamedghasempour@gmail.com>
 */
class TimeSynchronizationTest extends TestCase
{
    /**
     * @return void
     */
    public function testWongMethod(): void
    {
        $this->json("POST", route("time_synchronization"), [], ["accept" => "application/json"])->seeStatusCode(405);
    }

    /**
     * @return void
     */
    public function testWongTimestampDigitsCount(): void
    {
        $this->json("GET", route("time_synchronization", ["timestamp" => 123456]), [], ["accept" => "application/json"])
            ->seeStatusCode(422)
            ->seeJsonEquals(["timestamp" => ["The timestamp must be 10 digits."]]);
    }

    /**
     * @return void
     */
    public function testWongTimestampFormat(): void
    {
        $this->json("GET", route("time_synchronization", ["timestamp" => "test!!"]), [],
            ["accept" => "application/json"])
            ->seeStatusCode(422)
            ->seeJsonEquals(["timestamp" => ["The timestamp must be an integer.", "The timestamp must be 10 digits."]]);
    }

    /**
     * @return void
     */
    public function testUseCase(): void
    {
        // Date and time (GMT): Friday, October 16, 2020 2:35:29 AM
        $timestamp = 1602815729;
        $this->json("GET", route("time_synchronization", ["timestamp" => $timestamp]), [],
            ["accept" => "application/json"])->seeStatusCode(200)->seeJsonEquals([
            "mars_sol_date" => 52182.05587,
            "martian_coordinated_time" => "01:20:27"
        ]);
    }
}
