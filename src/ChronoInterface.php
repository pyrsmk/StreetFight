<?php

namespace StreetFight;

interface ChronoInterface
{
    /**
     * Constructor
     *
     * @param Time $time
     */
    public function __construct(Time $time);

    /**
     * Get the elapsed time (milliseconds)
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = self::MS);
}
