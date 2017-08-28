<?php

namespace StreetFight;

/**
 * Chronometer
 */
final class Chrono implements ChronoInterface
{
    /**
     * Initial time
     *
     * @var float
     */
    private $initialTime;

    /**
     * Constructor
     *
     * @param TimeStamp $timestamp
     */
    public function __construct(TimeStamp $timestamp)
    {
        $this->initialTime = $timestamp;
    }

    /**
     * Get the elapsed time (milliseconds)
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = TimeStampInterface::S)
    {
        $now = new TimeStamp();
        return $now->get($unit) - $this->initialTime->get($unit);
    }
}
