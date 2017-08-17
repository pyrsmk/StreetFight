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
    public function __construct(int $time = 2000)
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
        $overall = 0;
        $times = [];
        foreach ($this->challengers as $name => $challenger) {
            $times[$name] = 0;
        }
        // Run benchmarks
        do {
            foreach ($this->challengers as $name => $challenger) {
                // Run benchmark
                $t0 = microtime(true);
                $challenger->kick();
                $t1 = microtime(true);
                // Add time
                $times[$name] += $t1 - $t0;
                $overall += $times[$name];
                // Clean up memory
                gc_collect_cycles();
            }
        } while($overall < $this->time);
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
