<?php

namespace StreetFight\Report;

/**
 * A performance report in percentage
 */
final class PercentageReport implements ReportInterface
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
        $results = $this->report->compute();
        $max = max($results);
        return map($results, function ($time) use ($max) {
            return round($time / $max * 100, 2);
        });
    }
}
