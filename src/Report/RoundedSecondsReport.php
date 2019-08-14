<?php

namespace StreetFight\Report;

use function Funktions\map;

/**
 * A performance report in seconds (rounded)
 */
final class RoundedSecondsReport implements ReportInterface
{
    /**
     * The original report
     *
     * @var ReportInterface
     */
    private $report;

    /**
     * Constructor
     *
     * @param ReportInterface $report
     */
    public function __construct(ReportInterface $report)
    {
        $this->report = $report;
    }

    /**
     * Compute and return a performance report
     *
     * @return array
     */
    public function compute() : array
    {
        return map($this->report->compute(), function ($time) {
            return round($time, 2);
        });
    }
}
