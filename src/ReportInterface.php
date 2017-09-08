<?php

namespace StreetFight;

/**
 * Performance report interface
 */
interface ReportInterface
{
    /**
     * Compute and return a performance report
     *
     * @return array
     */
    public function getPerformance() : array;
}
