<?php

namespace StreetFight;

interface ReportInterface
{
    /**
     * Compute and return performance report (in percentage)
     *
     * @return array
     */
    public function getPerformance() : array;
}
