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
    private $challengers;

    /**
     * Begin callback
     *
     * @var callable
     */
    private $beginCallback;

    /**
     * End callback
     *
     * @var callable
     */
    private $endCallback;

    /**
     * Constructor
     *
     * @param int|null $matchTime
     */
    public function __construct(?int $matchTime = null)
    {
        $this->matchTime = $matchTime;
        $this->challengers = [];
        $this->beginCallback = function () {
        };
        $this->endCallback = function () {
        };
    }

    /**
     * Add a new challenger
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
     * Define the begin callback
     *
     * @param callable $callable
     * @return void
     */
    public function begin(callable $callable) : void
    {
        $this->beginCallback = $callable;
    }

    /**
     * Define the end callback
     *
     * @param callable $callable
     * @return void
     */
    public function end(callable $callable) : void
    {
        $this->endCallback = $callable;
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
        // Run benchmarks
        ob_start();
        $chrono = new Chrono(new TimeStamp());
        do {
            foreach ($this->challengers as $name => $challenger) {
                call_user_func($this->beginCallback);
                $challenger->kick();
                call_user_func($this->endCallback);
                gc_collect_cycles();
            }
        } while ($chrono->getElapsedTime(TimeStamp::MS) < $timeOver);
        ob_end_clean();
        // Profiling
        $report = new Report($this->challengers);
        return $report->getPerformance();
    }
}
