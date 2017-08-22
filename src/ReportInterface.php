<?php

namespace StreetFight;

interface ReportInterface
{
    /**
     * Constructor
     *
     * @param array $challengers
     */
    public function __construct(array $challengers);

    /**
     * Compute and return performance report (in percentage)
     *
     * @return array
     */
    public function getPerformance() : array;
}
