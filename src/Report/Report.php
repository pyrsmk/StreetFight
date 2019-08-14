<?php

namespace StreetFight\Report;

use StreetFight\Board\BoardInterface;
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
            function (array $final, BoardInterface $board) {
                foreach ($board->results() as $result) {
                    $final = $result->addTo($final);
                }
                return $final;
            },
            []
        );
    }
}
