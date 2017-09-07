<?php

namespace StreetFight;

use Closure;
use Exception;
use Chernozem\Container;

/**
 * A street fight match
 */
class Match implements MatchInterface
{
    /**
     * Container
     *
     * @var Chernozem\Container
     */
    private $container;

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
        $this->container = new Container();
        $this->matchTime = $matchTime;
        $this->challengers = [];
        $this->beginCallback = function () {
        };
        $this->endCallback = function () {
        };
    }

    /**
     * Get container
     *
     * @return Container
     */
    public function getContainer() : Container
    {
        return $this->container;
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
        $this->_verifyNumberOfChallengers();
        $timeOver = $this->_getMaximumMatchTime();
        $this->_runMatch($timeOver);
        $report = new Report($this->challengers);
        return $report->getPerformance();
    }

    /**
     * Verify the number of challengers
     *
     * @return void
     */
    private function _verifyNumberOfChallengers() : void
    {
        if (count($this->challengers) < 2) {
            throw new Exception('In order to run the benchmark, there must be at least 2 challengers in the match');
        }
    }

    /**
     * Get the maximum time allowed for a match
     *
     * @return int
     */
    private function _getMaximumMatchTime() : int
    {
        if ($this->matchTime === null) {
            return count($this->challengers) * 1000;
        } else {
            return $this->matchTime;
        }
    }

    /**
     * Run benchmarks
     *
     * @param int $timeOver
     * @return void
     */
    private function _runMatch(int $timeOver) : void
    {
        ob_start();
        $chrono = new Chrono(new TimeStamp());
        do {
            $this->_runRound();
        } while ($chrono->getElapsedTime(TimeStamp::MS) < $timeOver);
        ob_end_clean();
    }

    /**
     * Run an iteration over registered benchmarks
     *
     * @return void
     */
    private function _runRound() : void
    {
        ($this->beginCallback)($this->container);
        foreach ($this->challengers as $challenger) {
            $challenger->kick($this->container);
            gc_collect_cycles();
        }
        ($this->endCallback)($this->container);
    }
}
