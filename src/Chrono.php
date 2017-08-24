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
     * @param Time $time
     */
    public function __construct(TimeStamp $time)
    {
        $this->initialTime = $time;
    }

    /**
     * Get the elapsed time (milliseconds)
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = self::MS)
    {
        $now = new TimeStamp();
        return $now->get($unit) - $this->initialTime->get($unit);
    }
}
