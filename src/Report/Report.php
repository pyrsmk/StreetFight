<?php

namespace StreetFight\Report;

use StreetFight\Board\BoardInterface;

/**
 * A performance report in seconds
 */
final class Report implements ReportInterface
{
    /**
     * The challengers
     *
     * @var ChallengerListInterface
     */
    private $challengerList;

    /**
     * The results board
     *
     * @var BoardInterface
     */
    private $board;

    /**
     * Constructor
     *
     * @param ChallengerListInterface $challengerList
     * @param BoardInterface $board
     */
    public function __construct(ChallengerListInterface $challengerList, BoardInterface $board)
    {
        $this->challengerList = $challengerList;
        $this->board = $board;
    }

    /**
     * Compute and return a performance report
     *
     * @return array
     */
    public function compute() : array
    {
        $results = [];
        foreach($this->challengerList->items() as $challenger) {
            $results[$challenger->name] = array_reduce(
                $this->boards->filter($challenger),
                function ($time, $result) {
                    return $time + $result->time();
                },
                0
            );
        }
        return $results;
    }
}
