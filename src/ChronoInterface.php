<?php

namespace StreetFight;

interface ChronoInterface
{
    /**
     * Constructor
     *
     * @param TimeStamp $timestamp
     */
    public function __construct(TimeStamp $timestamp);

    /**
     * Get the elapsed time (milliseconds)
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = TimeStampInterface::MS);
}
