<?php

namespace StreetFight;

use StreetFight\Challenger\Challenger;
use StreetFight\Challenger\MutedChallenger;
use StreetFight\Challenger\GarbageCollectedChallenger;
use StreetFight\Challenger\ChallengerList;
use StreetFight\Hook\Hook;
use StreetFight\Board\BoardInterface;
use StreetFight\Hook\NullHook;

/**
 * Facade to ease StreetFight use
 */
class Facade implements FacadeInterface
{
    /**
     * The challenger list
     *
     * @var ChallengerListInterface
     */
    private $challengerList;

    /**
     * BEGIN hook
     *
     * @var HookInterface
     */
    private $beginHook;

    /**
     * END hook
     *
     * @var HookInterface
     */
    private $endHook;

    /**
     * BEFORE hook
     *
     * @var HookInterface
     */
    private $beforeHook;

    /**
     * AFTER hook
     *
     * @var HookInterface
     */
    private $afterHook;

    /**
     * Constructor
     *
     * @param Routine $routine
     * @param ChallengerListInterface $challengerList
     */
    public function __construct()
    {
        $this->challengerList = new ChallengerList();
        $this->beginHook = new NullHook();
        $this->endHook = new NullHook();
        $this->beforeHook = new NullHook();
        $this->afterHook = new NullHook();
    }

    /**
     * Add a new challenger
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function add(string $name, callable $callback): void
    {
        $this->challengerList = $this->challengerList->with(
            new GarbageCollectedChallenger(
                new MutedChallenger(
                    new Challenger($name, $callback)
                )
            )
        );
    }

    /**
     * Add a hook to run at beginning
     *
     * @param callable $callback
     * @return void
     */
    public function begin(callable $callback): void
    {
        $this->beginHook = new Hook($callback);
    }

    /**
     * Add a hook to run at the end
     *
     * @param callable $callback
     * @return void
     */
    public function end(callable $callback): void
    {
        $this->endHook = new Hook($callback);
    }

    /**
     * Add a hook to run before each kick
     *
     * @param callable $callback
     * @return void
     */
    public function before(callable $callback): void
    {
        $this->beforeHook = new Hook($callback);
    }

    /**
     * Add a hook to run after each kick
     *
     * @param callable $callback
     * @return void
     */
    public function after(callable $callback): void
    {
        $this->afterHook = new Hook($callback);
    }

    /**
     * Let's start the fight!
     *
     * @param integer $time
     * @return BoardInterface
     */
    public function fight(int $time = -1): BoardInterface
    {
        if ($time !== -1) {
            $rounds = new TimedRounds(
                $time,
                $this->challengerList,
                $this->beforeHook,
                $this->afterHook
            );
        } else {
            $rounds = new AutoTimedRounds(
                $this->challengerList,
                $this->beforeHook,
                $this->afterHook
            );
        }
        $this->beginHook->run();
        $board = $rounds->fight();
        $this->endHook->run();
        return $board;
    }
}
