<?php

namespace StreetFight;

use Exception;

/**
 * A street fight match
 */
class Match implements MatchInterface
{
    /**
     * The time of the match
     *
     * @var int
     */
    protected $matchTime;

    /**
     * The challengers
     *
     * @var array
     */
    protected $challengers = [];

    /**
     * Constructor
     *
     * @param int $time
     * @return void
     */
    public function __construct(int $matchTime = 0)
    {
        $this->matchTime = $matchTime;
    }

    /**
     * Add a challenger
     *
     * @param string $name
     * @param callable $challenger
     * @return void
     */
    public function add($name, callable $challenger) : void
    {
        $this->challengers[$name] = $challenger;
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
            throw new Exception("In order to run the benchmark, there must be at least 2 challengers in the match");
        }
        // Prepare
        $overallTime = 0;
        if ($this->matchTime === 0) {
            $maxTime = count($this->challengers) * 1000;
        } else {
            $maxTime = $this->matchTime;
        }
        $times = [];
        foreach ($this->challengers as $name => $challenger) {
            $times[$name] = 0;
        }
        // Run benchmarks
        ob_start();
        $overallTime0 = microtime(true);
        do {
            foreach ($this->challengers as $name => $challenger) {
                // Run benchmark
                $t0 = microtime(true);
                call_user_func($challenger);
                $t1 = microtime(true);
                // Add time
                $times[$name] += $t1 - $t0;
                // Clean up memory
                gc_collect_cycles();
            }
            $overallTime1 = microtime(true);
            $overallTime = ($overallTime1 - $overallTime0) * 1000;
        } while ($overallTime < $maxTime);
        ob_end_clean();
        // Profiling
        $max = max($times);
        $percents = [];
        foreach ($times as $name => $time) {
            $percents[$name] = round($time / $max * 100, 2);
        }
        arsort($percents);
        return $percents;
    }
}
