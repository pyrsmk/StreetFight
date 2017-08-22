<?php

namespace StreetFight;

use Exception;

/**
 * A street fight match
 */
class Match implements MatchInterface
{
    /**
     * The challengers
     *
     * @var array
     */
    protected $challengers = [];

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
        $timeOver = count($this->challengers) * $this->challengerTime;
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
