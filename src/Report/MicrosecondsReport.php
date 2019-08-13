<?php

namespace StreetFight\Report;

/**
 * A performance report in microseconds
 */
final class MicrosecondsReport implements ReportInterface
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
            return round($time * 10 ** 6, 2);
        });
    }
}
