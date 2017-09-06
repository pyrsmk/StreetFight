<?php

namespace StreetFight;

use Closure;
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
     * @var Closure
     */
    private $beginCallback;

    /**
     * End callback
     *
     * @var Closure
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
     * @param Closure $closure
     * @return void
     */
    public function add($name, Closure $closure) : void
    {
        $this->challengers[$name] = new Challenger($closure);
    }

    /**
     * Define the begin callback
     *
     * @param Closure $closure
     * @return void
     */
    public function begin(Closure $closure) : void
    {
        $this->beginCallback = $closure;
    }

    /**
     * Define the end callback
     *
     * @param Closure $closure
     * @return void
     */
    public function end(Closure $closure) : void
    {
        $this->endCallback = $closure;
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
                ($this->beginCallback)();
                $challenger->kick();
                ($this->endCallback)();
                gc_collect_cycles();
            }
        } while ($chrono->getElapsedTime(TimeStamp::MS) < $timeOver);
        ob_end_clean();
        // Profiling
        $report = new Report($this->challengers);
        return $report->getPerformance();
    }
}
