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
    const PERCENTAGE = 1;

    /**
     * Seconds type
     */
    const SECONDS = 2;

    /**
     * Milliseconds type
     */
    const MILLISECONDS = 3;

    /**
     * Microseconds type
     */
    const MICROSECONDS = 4;

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
        return $this->_sortResults(
            $this->_formatResults(
                $type,
                $this->_computeTotal(
                    $this->board->getMatchResults()
                )
            )
        );
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
     * Format results
     *
     * @param int $type
     * @param array $results
     * @return array
     */
    private function _formatResults(int $type, array $results) : array
    {
        switch ($type) {
            case self::PERCENTAGE:
                return $this->_formatToPercentage($results);
                break;
            case self::SECONDS:
                return $this->_formatToSeconds($results);
                break;
            case self::MILLISECONDS:
                return $this->_formatToMilliseconds($results);
                break;
            case self::MICROSECONDS:
                return $this->_formatToMicroseconds($results);
                break;
            default:
                throw new Exception('Invalid report type specified');
        }
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

    /**
     * Format results to milliseconds
     *
     * @param array $results
     * @return array
     */
    private function _formatToSeconds(array $results) : array
    {
        return array_map($results, function ($time) {
            return round($time, 2);
        });
    }

    /**
     * Format results to milliseconds
     *
     * @param array $results
     * @return array
     */
    private function _formatToMilliseconds(array $results) : array
    {
        return array_map($results, function ($time) {
            return round($time * 10 ** 3, 2);
        });
    }

    /**
     * Format results to microseconds
     *
     * @param array $results
     * @return array
     */
    private function _formatToMicroseconds(array $results) : array
    {
        return array_map($results, function ($time) {
            return round($time * 10 ** 6, 2);
        });
    }
}
