<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Challenger\ChallengerListInterface;
use StreetFight\Hook\HookInterface;
use StreetFight\Board\RoundBoardInterface;
use StreetFight\Board\RoundBoard;
use StreetFight\Board\Result;

/**
 * Run the round
 */
final class Round implements RoundInterface
{
    /**
     * Challenger list
     *
     * @var ChallengerListInterface
     */
    private $challengerList;

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
     * @param ChallengerListInterface $challengerList
     * @param HookInterface $beforeHook
     * @param HookInterface $afterHook
     */
    public function __construct(
        ChallengerListInterface $challengerList,
        HookInterface $beforeHook,
        HookInterface $afterHook
    )
    {
        $this->challengerList = $challengerList;
        $this->beforeHook = $beforeHook;
        $this->afterHook = $afterHook;
    }

    /**
     * Run the round
     *
     * @return RoundBoardInterface
     */
    public function fight(): RoundBoardInterface
    {
        $board = new RoundBoard();
        foreach ($this->challengerList->items() as $challenger) {
            $this->beforeHook->run();
            $board->with(
                new Result(
                    $challenger,
                    $challenger->kick()
                )
            );
            $this->afterHook->run();
        }
        return $this->board;
    }
}
