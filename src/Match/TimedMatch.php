<?php

declare(strict_types=1);

namespace StreetFight\Match;

use Illuminator\Chrono;
use StreetFight\Challenger\ChallengerListInterface;
use StreetFight\Hook\HookInterface;
use StreetFight\Board\BoardInterface;
use StreetFight\Board\Board;
use function Funktions\above;

/**
 * A match with a maximum time
 */
final class TimedMatch implements RoundsInterface
{
    /**
     * The maximum time
     *
     * @var integer
     */
    private $time;

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
     * @param int $time
     * @param ChallengerListInterface $challengerList
     * @param HookInterface $beforeHook
     * @param HookInterface $afterHook
     */
    public function __construct(
        int $time,
        ChallengerListInterface $challengerList,
        HookInterface $beforeHook,
        HookInterface $afterHook
    )
    {
        $this->time = above($time, 0);
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
        }
        while($chrono->readAsMilliseconds() < $this->time);
        return $board;
    }
}
