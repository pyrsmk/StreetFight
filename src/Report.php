<?php

namespace StreetFight;

final class Report
{
    /**
     * Challenger list
     *
     * @var array
     */
    private $challengers;

    /**
     * Constructor
     *
     * @param array $challengers
     */
    public function __construct(array $challengers)
    {
        foreach ($challengers as $name => $challenger) {
            if ($challenger instanceof Challenger === false) {
                throw new Exception("Challengers must be instances of 'StreetFight\ChallengerInterface'");
            }
        }
        $this->challengers = $challengers;
    }

    /**
     * Compute and return performance report (in percentage)
     *
     * @return array
     */
    public function getPerformance() : array
    {
        // Get fighting time
        $fightingTime = [];
        foreach ($this->challengers as $name => $challenger) {
            $fightingTime[$name] = $challenger->getFightingTime();
        }
        arsort($fightingTime);
        // Format time as percentage
        $theSlower = max($performance);
        return array_map(function ($time) use ($theSlower) {
            return round($time / $theSlower * 100, 2);
        }, $fightingTime);
    }
}
