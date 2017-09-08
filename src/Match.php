<?php

namespace StreetFight;

use Chernozem\Container;
use Closure;
use Exception;

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
     * Begin routine
     *
     * @var Closure
     */
    private $beginRoutine;

    /**
     * End routine
     *
     * @var Closure
     */
    private $endRoutine;

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
        $this->challengers[$name] = $closure;
    }

    /**
     * Define the begin routine callback
     *
     * @param Closure $closure
     * @return void
     */
    public function begin(Closure $closure) : void
    {
        $this->beginRoutine = $closure;
    }

    /**
     * Define the end routine callback
     *
     * @param Closure $closure
     * @return void
     */
    public function end(Closure $closure) : void
    {
        $this->endRoutine = $closure;
    }

    /**
     * Let's start the fight!
     *
     * @return StreetFight\BoardInterface
     */
    public function fight() : BoardInterface
    {
        $this->_verifyNumberOfChallengers();
        return $this->_runMatch(
            $this->_getMaximumMatchTime()
        );
    }

    /**
     * Run the match
     *
     * @param int $maxTime
     * @return StreetFight\BoardInterface
     */
    private function _runMatch(int $maxTime) : BoardInterface
    {
        $id = 0;
        $chrono = new Chrono();
        $board = new Board(array_keys($this->challengers));
        $this->_disableOutput();
        do {
            $this->_runRound(++$id, $board);
        } while ($chrono->getElapsedTime(Chrono::MS) < $maxTime);
        $this->_enableOutput();
        return $board;
    }

    /**
     * Run a round
     *
     * @param int $id
     * @param StreetFight\BoardInterface $board
     * @return void
     */
    private function _runRound(int $id, BoardInterface $board) : void
    {
        $this->_runBeginRoutine();
        foreach ($this->challengers as $name => $closure) {
            $chrono = new Chrono();
            $closure($this->container);
            $board->registerResult($id, $name, $chrono->getElapsedTime(Chrono::MS));
            $this->_cleanUpMemory();
        }
        $this->_runEndRoutine();
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
     * Disable the output to avoid benchmark callbacks to print anything
     *
     * @return void
     */
    private function _disableOutput() : void
    {
        ob_start();
    }

    /**
     * Re-enable the output
     *
     * @return void
     */
    private function _enableOutput() : void
    {
        ob_end_clean();
    }

    /**
     * Run the begin routine
     *
     * @return void
     */
    private function _runBeginRoutine() : void
    {
        ($this->beginCallback)($this->container);
    }

    /**
     * Run the end routine
     *
     * @return void
     */
    private function _runEndRoutine() : void
    {
        ($this->endCallback)($this->container);
    }

    /**
     * Clean up the memory
     *
     * @return void
     */
    private function _cleanUpMemory() : void
    {
        gc_collect_cycles();
    }
}
