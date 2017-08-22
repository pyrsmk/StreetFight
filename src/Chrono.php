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
     */
    public function __construct()
    {
        $this->initialTime = microtime(true);
    }

    /**
     * Get the elapsed time (milliseconds)
     *
     * @return float
     */
    public function getElapsedTime()
    {
        return (microtime(true) - $this->initialTime) * 1000;
    }
}
