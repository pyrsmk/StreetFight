<?php

namespace StreetFight\Report;

use function Funktions\array_arsort;

/**
 * A descending sorted performance report
 */
final class DescSortedReport implements ReportInterface
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
        return array_arsort(
            $this->report->compute()
        );
    }
}
