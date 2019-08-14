<?php

declare(strict_types=1);

namespace StreetFight\Match;

use Illuminator\Chrono;
use StreetFight\Challenger\ChallengerListInterface;
use StreetFight\Hook\HookInterface;
use StreetFight\Board\BoardInterface;
use StreetFight\Board\Board;

/**
 * A match with an auto-computed maximum time
 */
final class AutoTimedMatch implements MatchInterface
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
     * Run the match
     *
     * @return BoardInterface
     */
    public function fight(): BoardInterface
    {
        $board = new Board();
        $chrono = new Chrono();
        $chrono->start();
        do {
            $round = new Round(
                $this->challengerList,
                $this->beforeHook,
                $this->afterHook
            );
            $board = $board->with(
                $round->fight()
            );
            if (!isset($max_time)) {
                $max_time = $chrono->readAsMilliseconds() * 10;
            }
        }
        while($chrono->readAsMilliseconds() < $max_time);
        return $board;
    }
}
