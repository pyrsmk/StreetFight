<?php

namespace StreetFight;

use Exception;

/**
 * A performance report
 */
final class Report
{
    /**
     * Percentage type
     */
    const PERCENTAGE_TYPE = 1;

    /**
     * Time type
     */
    const TIME_TYPE = 2;

    /**
     * The results board
     *
     * @var StreetFight\BoardInterface
     */
    private $board;

    /**
     * Constructor
     *
     * @param StreetFight\BoardInterface
     */
    public function __construct(BoardInterface $board)
    {
        $this->board = $board;
    }

    /**
     * Compute and return a performance report
     *
     * @param int $type
     * @return array
     */
    public function getPerformance(int $type = self::PERCENTAGE_TYPE) : array
    {
        $results = $this->_sortResults(
            $this->_computeTotal(
                $this->board->getMatchResults()
            )
        );
        switch ($type) {
            case self::PERCENTAGE_TYPE:
                return $this->_formatToPercentage($results);
                break;
            case self::TIME_TYPE:
                return $results;
                break;
            default:
                throw new Exception('Invalid type passed');
        }
    }

    /**
     * Compute the total time for each challenger
     *
     * @param array $matchResults
     * @return array
     */
    private function _computeTotal(array $matchResults) : array
    {
        $results = [];
        foreach ($matchResults as $roundResults) {
            foreach ($roundResults as $name => $result) {
                if (!isset($results[$name])) {
                    $results[$name] = 0;
                }
                $results[$name] += $result;
            }
        }
        return $results;
    }

    /**
     * Sort results
     *
     * @param array $results
     * @return array
     */
    private function _sortResults(array $results) : array
    {
        arsort($results);
        return $results;
    }

    /**
     * Format results to percentage
     *
     * @param array $results
     * @return array
     */
    private function _formatToPercentage(array $results) : array
    {
        $max = max($results);
        return array_map($results, function ($time) use ($max) {
            return round($time / $max * 100, 2);
        });
    }
}
