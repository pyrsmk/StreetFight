<?php

namespace StreetFight\Report;

/**
 * A ascending sorted performance report
 */
final class AscSortedReport implements ReportInterface
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
        return array_asort(
            $this->report->compute()
        );
    }
}
