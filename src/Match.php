<?php

namespace StreetFight;

use Exception;

/**
 * A street fight match
 */
class Match implements MatchInterface
{
    /**
     * The max time of a match
     *
     * @var int
     */
    private $matchTime;

    /**
     * The challengers
     *
     * @var array
     */
    private $challengers = [];

    /**
     * Constructor
     *
     * @param int|null $matchTime
     */
    public function __construct(?int $matchTime = null)
    {
        $this->matchTime = $matchTime;
    }

    /**
     * Add a challenger
     *
     * @param string $name
     * @param callable $callable
     * @return void
     */
    public function add($name, callable $callable) : void
    {
        $this->challengers[$name] = new Challenger($callable);
    }

    /**
     * Let's start the fight!
     *
     * @return array
     */
    public function fight() : array
    {
        // Verify
        if (count($this->challengers) < 2) {
            throw new Exception('In order to run the benchmark, there must be at least 2 challengers in the match');
        }
        // Prepare
        if ($this->matchTime === null) {
            $timeOver = count($this->challengers) * 1000;
        } else {
            $timeOver = $this->matchTime;
        }
        $chrono = new Chrono();
        // Run benchmarks
        ob_start();
        do {
            foreach ($this->challengers as $name => $challenger) {
                $challenger->kick();
                gc_collect_cycles();
            }
        } while ($chrono->getElapsedTime() < $timeOver);
        ob_end_clean();
        // Profiling
        $report = new Report($this->challengers);
        return $report->getPerformance();
    }
}
