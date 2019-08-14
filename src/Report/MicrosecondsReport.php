<?php

namespace StreetFight\Report;

use function Funktions\map;

/**
 * A performance report in microseconds
 */
final class MicrosecondsReport implements ReportInterface
{
    /**
     * The original report
     *
     * @var Report
     */
    private $report;

    /**
     * Constructor
     *
     * @param Report $report
     */
    public function __construct(Report $report)
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
            return round($time * 10 ** 6, 2);
        });
    }
}
