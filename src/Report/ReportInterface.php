<?php

namespace StreetFight\Report;

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
    public function compute() : array;
}
