<?php

namespace StreetFight;

/**
 * Results board
 */
final class Board implements BoardInterface
{
    /**
     * Allowed challenger names
     *
     * @var array
     */
    private $names;

    /**
     * The results
     *
     * @var array
     */
    private $results;

    /**
     * Constructor
     *
     * @param array $names
     */
    public function __construct(array $names)
    {
        foreach ($names as $name) {
            if (!is_string($name)) {
                throw new Exception('Invalid challenger name');
            }
        }
        $this->names = $names;
        $this->results = [];
    }

    /**
     * Register a result
     *
     * @param string $name
     * @param float $result
     * @return void
     */
    public function registerResult(int $round, string $name, float $result) : void
    {
        $this->_initRound($round);
        $this->_verifyChallenger($name);
        $this->results[$round][$name] = $result;
    }

    /**
     * Get the results of the match
     *
     * @return array
     */
    public function getMatchResults() : array
    {
        return $this->results;
    }

    /**
     * Get the results of a round
     *
     * @return array
     */
    public function getRoundResults(int $round) : array
    {
        if (!isset($this->results[$round])) {
            throw new Exception("The round #$round is not registered");
        }
        return $this->results[$round];
    }

    /**
     * Get the result of a challenger in a round
     *
     * @return float
     */
    public function getChallengerResult(int $round, string $name) : array
    {
        $this->_verifyChallenger($name);
        $results = $this->getRoundResults($round);
        if(!isset($results[$name])) {
            throw new Exception("No result has been registered for the '$name' challenger in the round #$round");
        }
        return $this->results[$round];
    }

    /**
     * Initialize a round
     *
     * @param int $round
     * @return void
     */
    private function _initRound(int $round)
    {
        if (!isset($this->results[$round])) {
            $this->results[$round] = [];
        }
    }

    /**
     * Verify if a challenger exists
     *
     * @param string $name
     * @return void
     */
    private function _verifyChallenger(string $name) : void
    {
        if (!isset($this->names[$name])) {
            throw new Exception("The '$name' challenger is not registered");
        }
    }
}
