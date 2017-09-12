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
     * Match begin hook
     */
    const MATCH_BEGIN = 10;

    /**
     * Match end hook
     */
    const MATCH_END = 11;

    /**
     * Round begin hook
     */
    const ROUND_BEGIN = 20;

    /**
     * Round end hook
     */
    const ROUND_END = 21;

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
     * Hook list
     *
     * @var array
     */
    private $hooks;

    /**
     * Container
     *
     * @var Chernozem\Container
     */
    private $container;

    /**
     * Constructor
     *
     * @param int|null $matchTime
     */
    public function __construct(?int $matchTime = null)
    {
        $this->matchTime = $matchTime;
        $this->challengers = [];
        $this->hooks = [];
        $this->container = new Container();
    }

    /**
     * Add a new challenger
     *
     * @param string $name
     * @param Closure $closure
     * @return void
     */
    public function addNewChallenger($name, Closure $closure) : void
    {
        $this->challengers[$name] = $closure;
    }

    /**
     * Add a hook
     *
     * @param int $type
     * @param Closure $closure
     * @return void
     */
    public function addHook(int $type, Closure $closure) : void
    {
        $this->_verifyHookType($type);
        $this->hooks[$type][] = $closure;
    }

    /**
     * Run hooks from a type
     *
     * @param int $type
     * @return void
     */
    private function _runHook(int $type) : void
    {
        $this->_verifyHookType($type);
        if(isset($this->hooks[$type])) {
            foreach($this->hooks[$type] as $hook) {
                $hook($this->container);
            }
        }
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
        $this->_runHook(self::MATCH_BEGIN);
        do {
            $this->_runRound(++$id, $board);
        } while ($chrono->getElapsedTime(Chrono::MS) < $maxTime);
        $this->_runHook(self::MATCH_END);
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
        $this->_runHook(self::ROUND_BEGIN);
        foreach ($this->challengers as $name => $closure) {
            $chrono = new Chrono();
            $closure($this->container);
            $board->registerResult($id, $name, $chrono->getElapsedTime());
            $this->_cleanUpMemory();
        }
        $this->_runHook(self::ROUND_END);
    }

    /**
     * Verify hook type
     *
     * @param int $type
     * @return void
     */
    private function _verifyHooKType(int $type) : void
    {
        switch($type) {
            case self::MATCH_BEGIN:
            case self::MATCH_END:
            case self::ROUND_BEGIN:
            case self::ROUND_END:
                break;
            default:
                throw new Exception('Invalid hook type specified');
        }
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
     * Clean up the memory
     *
     * @return void
     */
    private function _cleanUpMemory() : void
    {
        gc_collect_cycles();
    }
}
