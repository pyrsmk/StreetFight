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
    protected $time;

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
    public function __construct(int $time = 0)
    {
        $this->time = $time;
    }

    /**
     * Add a challenger
     *
     * @param string $name
     * @param StreetFight\ChallengerInterface $challenger
     * @return void
     */
    public function add($name, ChallengerInterface $challenger) : void
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
        $maxTime = $this->time === 0 ? count($this->challengers) * 1000 : $this->time;
        $times = [];
        foreach ($this->challengers as $name => $challenger) {
            $times[$name] = 0;
        }
        // Run benchmarks
        $overallTime0 = microtime(true);
        do {
            foreach ($this->challengers as $name => $challenger) {
                // Run benchmark
                $t0 = microtime(true);
                $challenger->kick();
                $t1 = microtime(true);
                // Add time
                $times[$name] += $t1 - $t0;
                // Clean up memory
                gc_collect_cycles();
            }
            $overallTime1 = microtime(true);
            $overallTime = ($overallTime1 - $overallTime0) * 1000;
        } while($overallTime < $maxTime);
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
