<?php

namespace StreetFight\Report;

use function Funktions\map;

/**
 * A performance report in percentage
 */
final class PercentageReport implements ReportInterface
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
        $results = $this->report->compute();
        $max = max($results);
        return map($results, function ($time) use ($max) {
            return round($time / $max * 100, 2);
        });
    }
}
