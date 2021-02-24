<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * The class to convert UTC to MSD and MTC
 * PHP version >= 7.0
 *
 * @category Services
 * @package  Future
 * @author   Hamed Ghasempour <hamedghasempour@gmail.com>
 */
class MarsClock
{
    /**
     * @var int
     */
    private int $timestamp;

    /**
     * @var array
     */
    private array $config;

    /**
     * @var void
     */
    private $marsSolDate;

    /**
     * @var void
     */
    private $martianCoordinatedTime;

    /**
     * TimeConvertorService constructor.
     *
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->config = config("future");
        $this->timestamp = $carbon->timestamp;
        $this->marsSolDate = $this->getMarsSolDate();
        $this->martianCoordinatedTime = $this->getMartianCoordinatedTime($this->marsSolDate);
    }

    /**
     * @return float
     */
    private function getMarsSolDate(): float
    {
        $marsSolDate = (($this->timestamp + $this->config["leap_seconds"]) / $this->config["seconds_per_sol"]) +
            $this->config["correction"];
        return round($marsSolDate, $this->config["msd_precision"], PHP_ROUND_HALF_UP);
    }


    private function getMartianCoordinatedTime(float $marsSolDate): bool|string
    {
        $martianCoordinatedTime = round(fmod($marsSolDate, 1) * $this->config["seconds_per_day"], 0, PHP_ROUND_HALF_UP);
        return gmdate("H:i:s", (int) $martianCoordinatedTime);
    }

    public function getMsd(): float
    {
        return $this->marsSolDate;
    }

    public function getMtc(): bool|string
    {
        return $this->martianCoordinatedTime;
    }
}
