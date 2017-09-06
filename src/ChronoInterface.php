<?php

namespace StreetFight;

interface ChronoInterface
{
    /**
     * Get the elapsed time (milliseconds)
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = TimeStampInterface::S);
}
