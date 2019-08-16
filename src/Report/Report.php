<?php

namespace StreetFight\Report;

use StreetFight\Result\ResultListInterface;
use StreetFight\Match\MatchInterface;

/**
 * A performance report in seconds
 */
final class Report implements ReportInterface
{
    /**
     * A match
     *
     * @var MatchInterface
     */
    private $match;

    /**
     * Constructor
     *
     * @param MatchInterface $match
     */
    public function __construct(MatchInterface $match)
    {
        $this->match = $match;
    }

    /**
     * Compute and return a performance report
     *
     * @return array
     */
    public function compute() : array
    {
        return array_reduce(
            $this->match->fight(),
            function (array $final, ResultListInterface $resultList) {
                foreach ($resultList->results() as $result) {
                    $final = $result->addTo($final);
                }
                return $final;
            },
            []
        );
    }
}
