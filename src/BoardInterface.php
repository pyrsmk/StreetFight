<?php

namespace StreetFight;

/**
 * Board results interface
 */
interface BoardInterface
{
    /**
     * Get the results of the match
     *
     * @return array
     */
    public function getMatchResults() : array;

    /**
     * Get the results of a round
     *
     * @return array
     */
    public function getRoundResults(int $round) : array;

    /**
     * Get the result of a challenger in a round
     *
     * @return float
     */
    public function getChallengerResult(int $round, string $name) : array;
}
